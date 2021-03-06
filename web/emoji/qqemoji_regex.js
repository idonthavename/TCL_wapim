/**
 * Created by tt on 2017/9/13.
 */
function QQEmojiRegExp(content) {

    var re = /\/::\)|\/::~|\/::B|\/::\||\/:8-\)|\/::<|\/::\$|\/::X|\/::Z|\/::'\(|\/::-\||\/::@|\/::P|\/::D|\/::O|\/::\(|\/::\+|\/:--b|\/::Q|\/::T|\/:,@P|\/:,@-D|\/::d|\/:,@o|\/::g|\/:\|-\)|\/::!|\/::L|\/::>|\/::,@|\/:,@f|\/::-S|\/:\?|\/:,@x|\/:,@@|\/::8|\/:,@!|\/:!!!|\/:xx|\/:bye|\/:wipe|\/:dig|\/:handclap|\/:&-\(|\/:B-\)|\/:<@|\/:@>|\/::-O|\/:>-\||\/:P-\(|\/::'\||\/:X-\)|\/::\*|\/:@x|\/:8\*|\/:pd|\/:<W>|\/:beer|\/:basketb|\/:oo|\/:coffee|\/:eat|\/:pig|\/:rose|\/:fade|\/:showlove|\/:heart|\/:break|\/:cake|\/:li|\/:bome|\/:kn|\/:footb|\/:ladybug|\/:shit|\/:moon|\/:sun|\/:gift|\/:hug|\/:strong|\/:weak|\/:share|\/:v|\/:@\)|\/:jj|\/:@@|\/:bad|\/:lvu|\/:no|\/:ok|\/:love|\/:<L>|\/:jump|\/:shake|\/:<O>|\/:circle|\/:kotow|\/:turn|\/:skip|\/:oY|\/:#-0|\/:hiphot|\/:kiss|\/:<&|\/:&>/ig;
    return content.match(re);
}
function QQEmojiChRegExp(content){

    var re = /\[(微笑|撇嘴|色|发呆|得意|流泪|害羞|闭嘴|睡|大哭|尴尬|发怒|调皮|呲牙|惊讶|难过|酷|冷汗|抓狂|吐|偷笑|可爱|愉快|白眼|傲慢|饥饿|困|惊恐|流汗|憨笑|悠闲|大兵|奋斗|咒骂|疑问|嘘|晕|疯了|折磨|衰|骷髅|敲打|再见|擦汗|抠鼻|鼓掌|糗大了|坏笑|左哼哼|右哼哼|哈欠|鄙视|委屈|快哭了|阴险|亲亲|吓|可怜|菜刀|西瓜|啤酒|篮球|乒乓|咖啡|饭|猪头|玫瑰|凋谢|嘴唇|示爱|爱心|心碎|蛋糕|闪电|炸弹|刀|足球|瓢虫|便便|月亮|太阳|礼物|拥抱|强|弱|握手|胜利|抱拳|勾引|拳头|差劲|爱你|NO|OK|爱情|飞吻|跳跳|发抖|怄火|转圈|磕头|回头|跳绳|挥手|激动|街舞|献吻|左太极|右太极)\]/ig;
    return content.match(re);
}

function parse_content(content) {
    var match_emoji = QQEmojiRegExp(content);
    var match_emoji1 =QQEmojiChRegExp(content);

    console.log("list:" + match_emoji);
    if (match_emoji != null) {
        for (var i = 0; i < match_emoji.length; i++) {
            content = content.replace(match_emoji[i], "<span class='qqemoji qqemoji" + qqemoji_map[match_emoji[i]] + "'></span>");
        }
    }

    if (match_emoji1!=null) {
        for (var i = 0; i < match_emoji1.length; i++) {

            content = content.replace(match_emoji1[i], "<span class='qqemoji qqemoji" +
                qqemoji_ch_map[match_emoji1[i].replace("[","").replace("]","")] +
                "'></span>");
        }
    }
    return content;
}

qqemoji_map = {"/::)": "0",
    "/::~": "1",
    "/::B": "2",
    "/::|": "3",
    "/:8-)": "4",
    "/::<": "5",
    "/::$": "6",
    "/::X": "7",
    "/::Z": "8",
    "/::'(": "9",
    "/::-|": "10",
    "/::@": "11",
    "/::P": "12",
    "/::D": "13",
    "/::O": "14",
    "/::(": "15",
    "/::+": "16",
    "/:--b": "17",
    "/::Q": "18",
    "/::T": "19",
    "/:,@P": "20",
    "/:,@-D": "21",
    "/::d": "22",
    "/:,@o": "23",
    "/::g": "24",
    "/:|-)": "25",
    "/::!": "26",
    "/::L": "27",
    "/::>": "28",
    "/::,@": "29",
    "/:,@f": "30",
    "/::-S": "31",
    "/:?": "32",
    "/:,@x": "33",
    "/:,@@": "34",
    "/::8": "35",
    "/:,@!": "36",
    "/:!!!": "37",
    "/:xx": "38",
    "/:bye": "39",
    "/:wipe": "40",
    "/:dig": "41",
    "/:handclap": "42",
    "/:&-(": "43",
    "/:B-)": "44",
    "/:<@": "45",
    "/:@>": "46",
    "/::-O": "47",
    "/:>-|": "48",
    "/:P-(": "49",
    "/::'|": "50",
    "/:X-)": "51",
    "/::*": "52",
    "/:@x": "53",
    "/:8*": "54",
    "/:pd": "55",
    "/:<W>": "56",
    "/:beer": "57",
    "/:basketb": "58",
    "/:oo": "59",
    "/:coffee": "60",
    "/:eat": "61",
    "/:pig": "62",
    "/:rose": "63",
    "/:fade": "64",
    "/:showlove": "65",
    "/:heart": "66",
    "/:break": "67",
    "/:cake": "68",
    "/:li": "69",
    "/:bome": "70",
    "/:kn": "71",
    "/:footb": "72",
    "/:ladybug": "73",
    "/:shit": "74",
    "/:moon": "75",
    "/:sun": "76",
    "/:gift": "77",
    "/:hug": "78",
    "/:strong": "79",
    "/:weak": "80",
    "/:share": "81",
    "/:v": "82",
    "/:@)": "83",
    "/:jj": "84",
    "/:@@": "85",
    "/:bad": "86",
    "/:lvu": "87",
    "/:no": "88",
    "/:ok": "89",
    "/:love": "90",
    "/:<L>": "91",
    "/:jump": "92",
    "/:shake": "93",
    "/:<O>": "94",
    "/:circle": "95",
    "/:kotow": "96",
    "/:turn": "97",
    "/:skip": "98",
    "/:oY": "99",
    "/:#-": "100",
    "/:hiphot": "101",
    "/:kiss": "102",
    "/:<&": "103",
    "/:&>": "104" };

qqemoji_ch_map = {
    "微笑" : "0",
    "撇嘴" :"1",
    "色" : "2",
    "发呆" : "3",
    "得意" : "4",
    "流泪" : "5",
    "害羞" : "6",
    "闭嘴" : "7",
    "睡" : "8",
    "大哭" : "9",
    "尴尬" : "10",
    "发怒" : "11",
    "调皮" : "12",
    "呲牙" : "13",
    "惊讶" : "14",
    "难过" : "15",
    "酷" : "16",
    "冷汗" : "17",
    "抓狂" : "18",
    "吐" : "19",
    "偷笑" : "20",
    "可爱" : "21",
    "愉快" : "21",
    "白眼" : "22",
    "傲慢" : "23",
    "饥饿" : "24",
    "困" : "25",
    "惊恐" : "26",
    "流汗" : "27",
    "憨笑" : "28",
    "悠闲" : "29",
    "大兵" : "29",
    "奋斗" : "30",
    "咒骂" : "31",
    "疑问" : "32",
    "嘘" : "33",
    "晕" : "34",
    "疯了" : "35",
    "折磨" : "35",
    "衰" : "36",
    "骷髅" : "37",
    "敲打" : "38",
    "再见" : "39",
    "擦汗" : "40",
    "抠鼻" : "41",
    "鼓掌" : "42",
    "糗大了" : "43",
    "坏笑" : "44",
    "左哼哼" : "45",
    "右哼哼" : "46",
    "哈欠" : "47",
    "鄙视" : "48",
    "委屈" : "49",
    "快哭了" : "50",
    "阴险" : "51",
    "亲亲" : "52",
    "吓" : "53",
    "可怜" : "54",
    "菜刀" : "55",
    "西瓜" : "56",
    "啤酒" : "57",
    "篮球" : "58",
    "乒乓" : "59",
    "咖啡" : "60",
    "饭" : "61",
    "猪头" : "62",
    "玫瑰" : "63",
    "凋谢" : "64",
    "嘴唇" : "65",
    "示爱" : "65",
    "爱心" : "66",
    "心碎" : "67",
    "蛋糕" : "68",
    "闪电" : "69",
    "炸弹" : "70",
    "刀" : "71",
    "足球" : "72",
    "瓢虫" : "73",
    "便便" : "74",
    "月亮" : "75",
    "太阳" : "76",
    "礼物" : "77",
    "拥抱" : "78",
    "强" : "79",
    "弱" : "80",
    "握手" : "81",
    "胜利" : "82",
    "抱拳" : "83",
    "勾引" : "84",
    "拳头" : "85",
    "差劲" : "86",
    "爱你" : "87",
    "NO" : "88",
    "OK" : "89",
    "爱情" : "90",
    "飞吻" : "91",
    "跳跳" : "92",
    "发抖" : "93",
    "怄火" : "94",
    "转圈" : "95",
    "磕头" : "96",
    "回头" : "97",
    "跳绳" : "98",
    "挥手" : "99",
    "激动" : "100",
    "街舞" : "101",
    "献吻" : "102",
    "左太极" : "103",
    "右太极" : "104"
}
