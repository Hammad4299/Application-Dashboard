import TranslationCrudHelper from "../Crud/TranslationCrudHelper";
import TranslationModalHandler from "../ModalHandler/TranslationModalHandler";
require("../specific/translation-detail");

require('expose-loader?TranslationCrudHelper!../Crud/TranslationCrudHelper');
require('expose-loader?TranslationModalHandler!../ModalHandler/TranslationModalHandler');