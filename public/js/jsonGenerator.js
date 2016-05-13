/**
 * Created by Lorenzo on 28/11/14.
 */
var jsonGenerator = function () {
    return {
        jsonGen: function (action, data, type) {

            if (action != null && action) {
                var json = {action: action};

                if (data != null && data) {
                    json["data"] = data;
                }
                if (type != null && type) {
                    json["type"] = type;
                }
            } else {
                return null;
            }
            return json;
        }
    }
}();
