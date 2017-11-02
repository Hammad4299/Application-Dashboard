/**
 * Created by talha on 8/9/2017.
 */
export default class Place{
    public provider_id:string;
    public state:string;
    public city:string;
    public country:string;
    public lng:number;
    public lat:number;
    public zipcode:string;
    public address:string;
    public location_keyword:string;      //Used when prefilling autocomplete on edit
    public display_name:string;  //null or value set.
    public id:string;
    [key: string]: any;
}