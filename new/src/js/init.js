import { defaults } from "./modules/defaults";
import { tabs } from "./modules/tabs";
import { card } from "./modules/card";
import { needRec } from "./modules/needRecipient";
import { whatSearch } from "./modules/whatSearch";
import { product } from "./modules/product";
import { homePage } from "./modules/homePage";
import { regCtx } from "./modules/registration";
import { tips } from "./modules/tips";
import { needsPublish } from "./modules/needsPublish";
import { playVideo } from "./modules/playVideo";
import { acGroup } from "./modules/autocompleteAcGroup";
import { brandGroups } from "./modules/brandGroups";
import { config } from "./config";
import { slickCarousel } from "../../node_modules/slick-carousel/slick/slick.min";
import { select2 } from "../../node_modules/select2/dist/js/select2.full.min";
import { notifyjs } from "../../node_modules/notifyjs-browser/dist/notify";
// import { Fancybox } from "../../node_modules/@fancyapps/ui";

var App = () => { };

App.prototype.init = () => {
	defaults.init();
	tabs.init();
	card.init();
	needRec.init();
	whatSearch.init();
	product.init();
	homePage.init();
	regCtx.init();
	tips.init();
	needsPublish.init();
	playVideo.init();
	acGroup.init();
	brandGroups.init();
	// config.log("app init");

};

export { App };
