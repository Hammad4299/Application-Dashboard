import Place from "../DataClasses/Place";
import PlaceResult = google.maps.places.PlaceResult;
declare var $:any;

export class LocationHelper{
    protected components:any;
    protected mappingForPlace:any;
    constructor(){
        this.components = {
            street_number: 'long_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'long_name',
            country: 'long_name',
            postal_code: 'long_name'
        };

        this.mappingForPlace = {
            street_address: ['street_number','route'],
            city: ['locality'],
            state: ['administrative_area_level_1'],
            zipcode: ['postal_code'],
            country: ['country']
        };
    }

    public initForm(form:any,callback:(place: Place)=>void){
        // Create the autocomplete object, restricting the search to geographical
        // location types.


        let self = this;
        let elem = form.find('.js-place-autocomplete')[0];



        let type = $(elem).attr('data-type');
        if(type == undefined || type.length == 0)
            type = 'address';

        let autocomplete = new google.maps.places.Autocomplete(
            elem,
            {
                types: [type],
                componentRestrictions: {
                    country: 'us'
                }
            }
        );

        this.geolocate(autocomplete);

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', function () {
            let keyword = $(elem).val();
            let p = self.extractPlace(autocomplete.getPlace());
            p.location_keyword = keyword;
            p.display_name = null;
            LocationHelper.fillPlaceInfo(form,p);
        });
    }

    protected static fillPlaceInfo(form:any,place:Place){
        for(let p in place){
            form.find(`[name=${p}]`).val(place[p]);
        }
    }

    protected extractPlace(place: PlaceResult):Place{
        let ePlace = new Place();
        ePlace.lat = place.geometry.location.lat();
        ePlace.lng = place.geometry.location.lng();
        ePlace.provider_id = place.place_id;

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        let componentsRetrieved:any = {};
        for (let  i = 0; i < place.address_components.length; i++) {
            let addressType = place.address_components[i].types[0];
            if (this.components[addressType]) {
                if(this.components[addressType]==='long_name'){
                    componentsRetrieved[addressType] = place.address_components[i].long_name;
                }else{
                    componentsRetrieved[addressType] = place.address_components[i].short_name;
                }

            }
        }

        for(let p in this.mappingForPlace){
            if(this.mappingForPlace.hasOwnProperty(p)){
                ePlace[p] = '';
                let arr:any = [];
                this.mappingForPlace[p].map(function (p2:string) {
                    if(componentsRetrieved[p2]){
                        arr.push(componentsRetrieved[p2]);
                    }
                });

                ePlace[p] = arr.join(' ');
            }
        }

        return ePlace;
    }

    protected geolocate(autocomplete: google.maps.places.Autocomplete) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let  geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                let circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });

                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
}

let locationHelper =  new LocationHelper();
export default locationHelper;