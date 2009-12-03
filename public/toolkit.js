function Toolkit() {

	// show/hide target div
    this.toggle = function(id) {
        var element = document.getElementById(id);
        if (element.style.display == 'block') element.style.display = 'none';
        else element.style.display = 'block';
    }

    // return a JSON object ready for parsing
    this.json = function(jsonObject) {
        return eval('(' + jsonObject + ')');
    }

    // display Fari Messages returned via JSON
    this.fariMessage = function(elementId, jsonObject) {
        // evaluate the returned object
        var data = toolkit.json(jsonObject);
        var output = '';
        if (data.length > 1) {
            for (var key in data) {
                output += '<div id="status" style="display:block;" class="'
                    +data[key].status+'">'
                    +data[key].text+'</div>';
            }
        } else output += '<div id="status" style="display:block;" class="'
                    +data.status+'">'
                    +data.text+'</div>';
        document.getElementById(elementId).innerHTML = output;

        setTimeout("toolkit.toggle('"+elementId+"')", 5000);
    }
}

var toolkit = new Toolkit();
