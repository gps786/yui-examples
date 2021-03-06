<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Editor Data Post with Connection Manager</title>

<style type="text/css">
/*margin and padding on body element
  can introduce errors in determining
  element position and are not recommended;
  we turn them off as a foundation for YUI
  CSS treatments. */
body {
	margin:0;
	padding:0;
}
</style>

<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/fonts/fonts-min.css?_yuiversion=2.3.1" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/container/assets/skins/sam/container.css" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/menu/assets/skins/sam/menu.css" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/button/assets/skins/sam/button.css" />
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/editor/assets/skins/sam/editor.css" />
<link rel="stylesheet" type="text/css" href="http://us.js2.yimg.com/us.js.yimg.com/i/ydn/yuiweb/css/dpsyntax-min-11.css">

<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/utilities/utilities.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/container/container-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/menu/menu-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/button/button-beta-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/editor/editor-beta-min.js"></script>
<script src="http://us.js2.yimg.com/us.js.yimg.com/i/ydn/yuiweb/js/dpsyntax-min-2.js"></script>


<!--there is no custom header content for this example-->

</head>

<body class="yui-skin-sam">

<h1>Editor Data Post with Connection Manager</h1>

<div class="exampleIntro">
	<p>This example demonstrates how to use <a href="http://developer.yahoo.com/yui/connection/">Connection Manager</a> to post data to the server, filter it and return it to the Editor.</p>
			
</div>

<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->

<style>
    #submitEditor {
        margin: 1em;
    }
    #status {
        margin: 2em;
        border: 1px solid black;
        background-color: #ccc;
        height: 4em;
    }
</style>

<form method="post" action="#" id="form1">
<p>This page is in response to this <a href="https://sourceforge.net/tracker/index.php?func=detail&aid=1830756&group_id=165715&atid=836476">Sorceforge Ticket</a></p>
<textarea id="editor" name="editor" rows="20" cols="75">
This is some more test text.<br>This is some more test text.<br>This is some more test text.<br>This is some more test text.<br>This is some more test text.<br>This is some more test text.<br>This is some more test text.<br>
</textarea>
<input type="checkbox" id="filter" checked> <label for="filter">Filter editor data on server.</label><br>

<button type="button" id="submitEditor">Submit Form</button><br>

<div id="status"></div>
</form>
<h2>The Code</h2>
<textarea name="code" class="JScript">
    var myEditor = new YAHOO.widget.Editor('editor', myConfig);
    myEditor.on('editorContentLoaded', function() {
        // ------------ inserted code ------------
        var isRendered = myEditor._rendered;
        if (isRendered) {
            alert("Rich text area has been rendered");
        } else {
            alert("Rich text area has not been rendered");
        }
        var doc = myEditor._getDoc();
        if (doc == null) {
            alert("doc is null");
        } else {
            alert("doc is not null");
        }
        var docBody = doc.body;
        if (docBody == null) {
            alert("docBody is null");
        } else {
            alert("docBody is not null");
        }
        myEditor.setEditorHTML("abc");
        // -----------------------------------------
    });
    myEditor.render();

</textarea>

<script>
(function() {
    var Dom = YAHOO.util.Dom,
        Event = YAHOO.util.Event,
        status = null;

        var handleSuccess = function(o) {
            YAHOO.log('Post success', 'info', 'example');
            var data = eval('(' + o.responseText + ')');
            status.innerHTML = 'Status: ' + data.Results.status + '<br>Filter: ' + data.Results.filter + '<br>' + (new Date().toString());
            myEditor.setEditorHTML(data.Results.data);
        }
        var handleFailure = function(o) {
            YAHOO.log('Post failed', 'info', 'example');
            var data = eval('(' + o.responseText + ')');
            status.innerHTML = 'Status: ' + data.Results.status + '<br>';
        }

        var callback = {
            success: handleSuccess,
            failure: handleFailure
        };

    
    YAHOO.log('Create Button Control (#toggleEditor)', 'info', 'example');
    var _button = new YAHOO.widget.Button('submitEditor');

    var myConfig = {
        height: '300px',
        width: '530px',
        animate: true,
        dompath: true
    };

    YAHOO.log('Create the Editor..', 'info', 'example');
    var myEditor = new YAHOO.widget.Editor('editor', myConfig);
    myEditor.on('editorContentLoaded', function() {
        // ------------ inserted code ------------
        var isRendered = myEditor._rendered;
        if (isRendered) {
            alert("Rich text area has been rendered");
        } else {
            alert("Rich text area has not been rendered");
        }
        var doc = myEditor._getDoc();
        if (doc == null) {
            alert("doc is null");
        } else {
            alert("doc is not null");
        }
        var docBody = doc.body;
        if (docBody == null) {
            alert("docBody is null");
        } else {
            alert("docBody is not null");
        }
        myEditor.setEditorHTML("abc");
        // -----------------------------------------
    });
    myEditor.render();

    _button.on('click', function(ev) {
        YAHOO.log('Button clicked, initiate transaction', 'info', 'example');
        Event.stopEvent(ev);
        myEditor.saveHTML();
        window.setTimeout(function() {
            var sUrl = "assets/post.php";
            var data = 'filter=' + ((Dom.get('filter').checked) ? 'yes' : 'no') + '&editor_data=' + encodeURI(myEditor.get('textarea').value);
            var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, data);
        }, 200);
    });
    
    

    Event.on(window, 'load', function() {
        status = Dom.get('status');
        dp.SyntaxHighlighter.HighlightAll('code');
    });
})();
</script>


<!--END SOURCE CODE FOR EXAMPLE =============================== -->
</body>
</html>
