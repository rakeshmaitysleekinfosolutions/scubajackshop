import '../TemplateData/UnityProgress';
import '../Build/UnityLoader'
var unityInstance = UnityLoader.instantiate("unityContainer", "Build/ChooseTheABCLowercase.json", {onProgress: UnityProgress});
