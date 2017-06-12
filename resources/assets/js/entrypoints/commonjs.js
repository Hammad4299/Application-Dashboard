import TimeHelper from '../Utility/time'
import '../startup';
import '../FormSubmitters/FormMapper';
import CrudHelper from "../Crud/CrudHelper";
import BaseModalHandler from "../ModalHandler/BaseModalHandler";

require('expose-loader?Globals!../globals');
require('expose-loader?TimeHelper!../Utility/time');
require('expose-loader?FormSubmitter!../FormSubmitters/FormSubmitter');
require('expose-loader?BaseModalHandler!../ModalHandler/BaseModalHandler')
require('expose-loader?CrudHelper!../Crud/CrudHelper');