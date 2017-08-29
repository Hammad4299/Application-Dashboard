import LanguageCrudHelper from "../Crud/LanguageCrudHelper";
import LanguageModalHandler from "../ModalHandler/LanguageModalHandler";
require("../specific/language-detail");

require('expose-loader?LanguageCrudHelper!../Crud/LanguageCrudHelper');
require('expose-loader?LanguageModalHandler!../ModalHandler/LanguageModalHandler');