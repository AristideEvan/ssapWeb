import { InitDropZone } from "./modules/InitDropZone.js";
import { DynamicZone } from "./modules/DynamicZone.js";
import { InputsTrim } from "./modules/InputsTrim.js";
import { Http } from "./modules/Http.js";
import { InitDropZone2 } from "./modules/InitDropZone2.js";
import { InitAsideToggle } from "./modules/InitAsideToggle.js";
import { InitHideOnClick } from "./modules/InitHideOnClick.js";
import { Form } from "./modules/Form.js";
import { InitDropZoneVideo } from "./modules/InitDropZoneVideo.js";

window.xlab = window.xlab || {};
window.xlab.InitDropZone = InitDropZone;
window.xlab.DynamicZone = DynamicZone;
window.xlab.InputsTrim = InputsTrim;
window.xlab.Http = new Http();
window.xlab.InitDropZone2 = InitDropZone2;
window.xlab.InitDropZoneVideo = InitDropZoneVideo;
window.xlab.InitAsideToggle = InitAsideToggle;
window.xlab.InitHideOnClick = InitHideOnClick;
window.xlab.Form = Form;

// console.log('xlab loaded');

// InitWindowClickHideElement