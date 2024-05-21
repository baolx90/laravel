console.log("loaded wonderchat.js");

const removeHttp = (url) => {
    if (url === undefined) {
        return "";
    }

    return url.replace(/^https?:\/\//, "");
};

function isCrossOriginFrame(iframe = undefined) {
    try {
        if (iframe !== undefined) {
            return !iframe?.window?.top?.location.hostname;
        }

        return !window?.top?.location.hostname;
    } catch (e) {
        return true;
    }
}

const oldOverflow = document?.body?.style?.overflow ?? "";

const chatScript = document.querySelector(
    "script[data-name='lamxuanbao']"
);

const offsetBottom = chatScript?.getAttribute(
    "data-widget-offset-bottom"
);
const offsetRight = chatScript?.getAttribute("data-widget-offset-right");
const placement = chatScript?.getAttribute("data-placement") || "right";
let wonderchatId = chatScript?.getAttribute("data-id");

const chatAddress = chatScript?.getAttribute("data-address");
const greeting = chatScript?.getAttribute("greeting");
const dataGreeting = chatScript?.getAttribute("data-greeting");
const dataIgnorePaths = chatScript?.getAttribute("data-ignore-paths");
const dataHeaderHidden = chatScript?.getAttribute("data-header-hidden");
const dataLanguage = chatScript?.getAttribute("data-language");
const dataContext = chatScript?.getAttribute("data-context");
const dataUserId = chatScript?.getAttribute("data-user-id");
const dataCustomCss = chatScript?.getAttribute("data-custom-css");
const dataWidgetMovable = chatScript?.getAttribute("data-movable");

let widgetSize = chatScript?.getAttribute("data-widget-size");
let widgetButtonSize = chatScript?.getAttribute(
    "data-widget-button-size"
);

const wonderchatWrapper = document.createElement("div");
wonderchatWrapper.id = "wonderchat-wrapper";
wonderchatWrapper.style.zIndex = "-942999";
wonderchatWrapper.style.background = "aqua";
wonderchatWrapper.style.overflow = "hidden";
wonderchatWrapper.style.position = "fixed";
wonderchatWrapper.style.bottom = "0px";
if (placement === "left") {
    wonderchatWrapper.style.left = "0px";
} else {
    wonderchatWrapper.style.right = "0px";
}

wonderchatWrapper.style.width = "350px";
wonderchatWrapper.style.height = "380px";

if (offsetBottom) {
    wonderchatWrapper.style.marginBottom = offsetBottom;
}
if (offsetRight) {
    wonderchatWrapper.style.marginRight = offsetRight;
}

let widgetOpen = true;

document.body.appendChild(wonderchatWrapper);

const VALID_WIDGET_SIZES = {
    small: {
        height: "680px",
        width: "384px",
    },
    normal: {
        height: "800px",
        width: "440px",
    },
    large: {
        height: "820px",
        width: "572px",
    },
};

if (!VALID_WIDGET_SIZES[widgetSize]) {
    widgetSize = "normal";
}

const iframe = document.createElement("iframe");

function getIframeUrl(chatbotId) {
    let iframeUrl = `${
        window.location.protocol === "https:" ? "https" : "http"
    }://${removeHttp(chatAddress)}/widget/${chatbotId}`;
    const urlObj = new URL(iframeUrl);
    const wonderchatParams = new URLSearchParams();

    if (dataGreeting) {
        wonderchatParams.append("greeting", dataGreeting);
    } else if (greeting) {
        wonderchatParams.append("greeting", greeting);
    }

    if (widgetButtonSize) {
        wonderchatParams.append("widgetButtonSize", widgetButtonSize);
    }

    if (widgetSize === "large") {
        wonderchatParams.append("widgetSize", "large");
    }

    if (dataHeaderHidden) {
        wonderchatParams.append("headerHidden", true);
    }

    if (dataLanguage) {
        wonderchatParams.append("language", dataLanguage);
    }

    if (dataContext) {
        wonderchatParams.append("context", dataContext);
    }

    if (dataUserId) {
        wonderchatParams.append("userId", dataUserId);
    }

    if (placement) {
        wonderchatParams.append("placement", placement);
    }

    if (dataCustomCss) {
        wonderchatParams.append("customCss", encodeURIComponent(dataCustomCss));
    }

    urlObj.search = wonderchatParams.toString();

    iframeUrl = urlObj.toString();
    return iframeUrl;
}

function changeWonderchatChatbotId(chatbotId) {
    wonderchatId = chatbotId;
    const iframe = document.getElementById("wonderchat");
    const iframeUrl = getIframeUrl(chatbotId);
    iframe.setAttribute("src", iframeUrl);
}

console.log(wonderchatId)
console.log(123123123)
let iframeUrl = getIframeUrl(wonderchatId);

iframe.setAttribute("src", iframeUrl);

iframe.setAttribute("frameborder", "0");
iframe.setAttribute("scrolling", "no");
iframe.setAttribute("allow", "fullscreen; clipboard-read; clipboard-write");
iframe.style.width = "100%";
iframe.style.height = "100%";
iframe.style.background = "transparent";
iframe.style["min-height"] = "auto";
iframe.id = "wonderchat";

function shouldAppendIframe() {
    if (!dataIgnorePaths) {
        if (!document.getElementById("wonderchat")) {
            wonderchatWrapper.style.zIndex = "9249299";
            wonderchatWrapper?.appendChild(iframe);
        }
    } else {
        const paths = dataIgnorePaths.split(",");
        for (let path of paths) {
            if (path.endsWith("*")) {
                const trimmedPath = path.slice(0, path.length - 2);
                const href = window.location.href;
                if (href.startsWith(trimmedPath)) {
                    const iframeToRemove = document.getElementById("wonderchat");
                    if (iframeToRemove) {
                        iframeToRemove.parentNode.removeChild(iframeToRemove);
                        wonderchatWrapper.style.zIndex = "-9249299";
                    }
                    return;
                }
            } else {
                if (path.endsWith("/")) {
                    path = path.slice(0, path.length - 1);
                }
                let url = window.location.href;
                if (url.endsWith("/")) {
                    url = url.slice(0, url.length - 1);
                }
                if (path === url) {
                    const iframeToRemove = document.getElementById("wonderchat");
                    if (iframeToRemove) {
                        iframeToRemove.parentNode.removeChild(iframeToRemove);
                        wonderchatWrapper.style.zIndex = "-9249299";
                    }
                    return;
                }
            }
        }
        if (!document.getElementById("wonderchat")) {
            wonderchatWrapper?.appendChild(iframe);
            wonderchatWrapper.style.zIndex = "9249299";
        }
    }
}

shouldAppendIframe();

let oldHref = document.location.href;

if (dataIgnorePaths) {
    window.onload = function () {
        const bodyList = document.querySelector("body");

        const observer = new MutationObserver(function (mutations) {
            if (oldHref != document.location.href) {
                oldHref = document.location.href;
                shouldAppendIframe();
                /* Changed ! your code here */
            }
        });

        const config = {
            childList: true,
            subtree: true,
        };

        observer.observe(bodyList, config);
    };
}

function waitForElm(selector) {
    return new Promise((resolve) => {
        if (document.querySelector(selector)) {
            return resolve(document.querySelector(selector));
        }

        const observer = new MutationObserver((mutations) => {
            if (document.querySelector(selector)) {
                resolve(document.querySelector(selector));
                observer.disconnect();
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
        });
    });
}

waitForElm("#wonderchat").then((elm) => {
    var iframe = document.getElementById("wonderchat");
    if (dataWidgetMovable) {
        const dragger = document.createElement("div");
        dragger.style.position = "absolute";
        dragger.style.top = "20px";
        dragger.style.left = "60px";
        dragger.style.width = "220px";
        dragger.style.height = "85px";
        dragger.style.cursor = "grab";

        var isDragging = false;
        var startPos = { x: 0, y: 0 };
        var elementPos = { x: 0, y: 0 };

        // Mouse down event
        dragger.addEventListener("mousedown", function (e) {
            isDragging = true;
            dragger.style.top = "20px";
            dragger.style.left = "60px";
            dragger.style.width = "300px";
            dragger.style.height = "800px";

            startPos = {
                x: e.clientX,
                y: e.clientY,
            };

            elementPos = {
                x:
                    window.innerWidth -
                    wonderchatWrapper.offsetLeft -
                    wonderchatWrapper.offsetWidth,
                y:
                    window.innerHeight -
                    wonderchatWrapper.offsetTop -
                    wonderchatWrapper.offsetHeight,
            };
            dragger.style.cursor = "grabbing";
        });

        // Mouse move event
        document.addEventListener("mousemove", function (e) {
            if (isDragging) {
                // Calculate the new position
                var dx = startPos.x - e.clientX;
                var dy = startPos.y - e.clientY;
                // Update the element's position
                wonderchatWrapper.style.right = elementPos.x + dx + "px";
                wonderchatWrapper.style.bottom = elementPos.y + dy + "px";
            }
        });

        // Mouse up event
        window.addEventListener("mouseup", function () {
            isDragging = false;
            dragger.style.top = "20px";
            dragger.style.left = "60px";
            dragger.style.width = "220px";
            dragger.style.height = "85px";
            dragger.style.cursor = "grab";
        });

        wonderchatWrapper.appendChild(dragger);
    }
    window.addEventListener(
        "message",
        function (e) {
            if (!e.origin.match(chatAddress)) {
                return;
            }
            let type;
            let payload;

            try {
                const parsed = JSON.parse(e.data);
                type = parsed.type;
                payload = parsed.payload;
            } catch (err) {
                return;
            }

            switch (type) {
                case "changeWrapperMargin": {
                    if (offsetBottom) {
                        wonderchatWrapper.style.marginBottom = offsetBottom;
                    }
                    if (offsetRight) {
                        wonderchatWrapper.style.marginRight = offsetRight;
                    }
                    break;
                }
                case "showChat": {
                    if (payload.isOpen === true) {
                        /* Non mobile, normal widget */
                        if (window.matchMedia("(min-width: 800px)").matches) {
                            iframe.parentNode.style.height = `min(100%, ${VALID_WIDGET_SIZES[widgetSize].height})`;
                            iframe.parentNode.style.width = `min(100%, ${VALID_WIDGET_SIZES[widgetSize].width})`;
                            document.body.style.overflow = oldOverflow;
                        } else {
                            /* Mobile, full screen widget */
                            iframe.parentNode.style.height = "100%";
                            iframe.parentNode.style.width = "100%";
                            document.body.style.setProperty(
                                "overflow",
                                "hidden",
                                "important"
                            );
                            if (offsetBottom) {
                                wonderchatWrapper.style.marginBottom = "0px";
                            }
                            if (offsetRight) {
                                wonderchatWrapper.style.marginRight = "0px";
                            }
                        }
                        widgetOpen = true;
                    } else {
                        iframe.parentNode.style.height =
                            widgetButtonSize === "large" ? "100px" : "90px";
                        iframe.parentNode.style.width =
                            widgetButtonSize === "large" ? "100px" : "90px";
                        document.body.style.overflow = oldOverflow;
                        widgetOpen = false;
                    }
                    break;
                }
                case "chatbotLoaded":
                    const chatHistory = JSON.parse(
                        dataUserId
                            ? this.localStorage.getItem(
                                `chatHistory_${wonderchatId}_${dataUserId}`
                            )
                            : localStorage.getItem(`chatHistory_${wonderchatId}`)
                                ? localStorage.getItem(`chatHistory_${wonderchatId}`)
                                : localStorage.getItem(`chatHistory`)
                                    ? localStorage.getItem(`chatHistory`)
                                    : "[]"
                    );
                    const chatlogId = dataUserId
                        ? this.localStorage.getItem(
                            `chatlogId_${wonderchatId}_${dataUserId}`
                        )
                        : localStorage.getItem(`chatlogId_${wonderchatId}`) ??
                        localStorage.getItem(`chatlogId`) ??
                        null;
                    const userDetail = JSON.parse(
                        this.localStorage.getItem(`userDetail_${wonderchatId}`) ??
                        this.localStorage.getItem(`userDetail`) ??
                        "{}"
                    );
                    const userToken = localStorage.getItem(`${chatlogId}_token`) ?? null;

                    iframe.contentWindow.postMessage(
                        JSON.stringify({
                            type: "chatHistory",
                            payload: {
                                chatHistory,
                                chatlogId,
                                userDetail,
                                userToken,
                            },
                        }),
                        "*"
                    );
                    /* Only check once the chatbot has been loaded */
                    /* Only show greeting message if not shown before in this session, and if the widget is closed */
                    setTimeout(() => {
                        if (
                            !sessionStorage.getItem("shouldNotGreet") &&
                            !widgetOpen &&
                            payload.shouldSpontaneouslyGreet
                        ) {
                            iframe.contentWindow.postMessage(
                                JSON.stringify({ type: "showGreeting" }),
                                "*"
                            );
                            wonderchatWrapper.style.height = "185px";
                            wonderchatWrapper.style.width = "min(100%, 320px)";
                        }
                    }, 1000);
                    break;

                case "chatbotAcknowledged": {
                    sessionStorage.setItem("shouldNotGreet", "1");
                    break;
                }
                case "requestWidth": {
                    if (window.matchMedia("(min-width: 800px)").matches) {
                        iframe.contentWindow.postMessage(
                            JSON.stringify({ type: `popup` }),
                            "*"
                        );
                    } else {
                        iframe.contentWindow.postMessage(
                            JSON.stringify({ type: "fullscreen" }),
                            "*"
                        );
                    }
                    break;
                }
                case "chatHistory": {
                    const { chatHistory, chatlogId } = payload;
                    if (dataUserId) {
                        this.localStorage.setItem(
                            `chatHistory_${wonderchatId}_${dataUserId}`,
                            JSON.stringify(chatHistory)
                        );
                    } else {
                        this.localStorage.setItem(
                            `chatHistory_${wonderchatId}`,
                            JSON.stringify(chatHistory)
                        );
                    }

                    if (chatlogId) {
                        if (dataUserId) {
                            this.localStorage.setItem(
                                `chatlogId_${wonderchatId}_${dataUserId}`,
                                chatlogId
                            );
                        } else {
                            this.localStorage.setItem(`chatlogId_${wonderchatId}`, chatlogId);
                        }
                    }
                    break;
                }

                case "clearChatHistory": {
                    const chatlogId = this.localStorage.getItem(
                        `chatlogId_${wonderchatId}`
                    );
                    this.localStorage.removeItem(`chatlogId`);
                    this.localStorage.removeItem(`chatHistory`);
                    this.localStorage.removeItem(`userDetail`);
                    this.localStorage.removeItem(`chatlogId_${wonderchatId}`);
                    this.localStorage.removeItem(
                        `chatlogId_${wonderchatId}_${dataUserId}`
                    );
                    this.localStorage.removeItem(`chatHistory_${wonderchatId}`);
                    this.localStorage.removeItem(
                        `chatHistory_${wonderchatId}_${dataUserId}`
                    );
                    this.localStorage.removeItem(`userDetail_${wonderchatId}`);
                    this.localStorage.removeItem(`${chatlogId}_token`);
                    break;
                }

                /*
                  detail: 'EMAIL' | 'PHONE_NUMBER' | 'NAME'
                */

                case "userDetailCollected": {
                    const { detail } = payload;
                    const savedDetail =
                        this.localStorage.getItem(`userDetail_${wonderchatId}`) ??
                        this.localStorage.getItem(`userDetail`) ??
                        "{}";
                    try {
                        const parsed = JSON.parse(savedDetail);
                        const updatedDetail = { ...parsed, [detail]: true };
                        this.localStorage.setItem(
                            `userDetail_${wonderchatId}`,
                            JSON.stringify(updatedDetail)
                        );
                    } catch (err) {
                        console.log(err);
                    }
                    break;
                }

                case "linkClick": {
                    const { href } = payload;
                    window.location.href = href;
                    break;
                }

                case "chatlogToken": {
                    const { chatlogId, userToken } = payload;
                    this.localStorage.setItem(`${chatlogId}_token`, userToken);
                }
            }
        },
        false
    );
});
