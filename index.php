<!DOCTYPE html>
<html lang="en">
<head>
    <title>Uploading video with a progress bar</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
    
form {
    margin: 5% auto;
    border-radius: .3rem;
    padding: 1.3rem;
    border: #2274ac40 1px solid;
    width:30%;
    text-align:center;
    
}
input {
    width: 90%;
    border: 0;
    padding: 20px;
    border-radius: 6px;
    margin-bottom: 10px;
    border: 1px solid #839af5;
}
.btn {
    width: 100%;
    padding: .5rem;
    border: 0;
    background: #fe6f27;
    font-size: 1.2em;
    color: #fff;
    text-shadow: 1px 1px 0px rgba(0, 0, 0, .4);
    box-shadow: 0px 3px 0px #fe6f27;
    margin-top: 1.2rem;
}
.btn:hover {
    background: #00398c;
    color: #b5b5b5;
    box-shadow: none;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #d6d8db;
    background-color: #3c4760;
    background-clip: padding-box;
    border: 1px solid #72a7db;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.progress {
    background-color: #3fee8c;
    position: relative;
    margin: 20px;
    height: 1.2rem;
}
.progress-bar {
    background-color: #7eeed8;
    width: 100%;
    height: 1.2rem;
}
progress::-webkit-progress-value {
    background: #3fee8c;
}
progress::-webkit-progress-bar {
    background: #1e1e3c;
}
progress::-moz-progress-bar {
    background: #3fee8c;
}
    </style>
</head>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-2"></div>
        <div class="col-8">
            <form id="upload_form" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <input type="file" name="uploadingfile" id="uploadingfile">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="button" value="Upload File" name="btnSubmit"
                           onclick="uploadFileHandler()">
                </div>
                <div class="form-group">
                    <div class="progress" id="progressDiv" style="display:none;">
                        <progress id="progressBar" value="0" max="100" style="width:100%; height: 1.2rem;"></progress>
                    </div>
                </div>
                <div class="form-group">
                    <h3 id="status"></h3>
                    <p id="uploaded_progress"></p>
                </div>
            </form>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<script>
    function _(abc) {
    return document.getElementById(abc);
}
function uploadFileHandler() {
    document.getElementById('progressDiv').style.display='block';
    var file = _("uploadingfile").files[0];
    var formdata = new FormData();
    formdata.append("uploadingfile", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "upload.php");
    ajax.send(formdata);
}
function progressHandler(event) { 
    var loaded = new Number((event.loaded / 1048576));//Make loaded a "number" and divide bytes to get Megabytes
    var total = new Number((event.total / 1048576));//Make total file size a "number" and divide bytes to get Megabytes
    _("uploaded_progress").innerHTML = "Uploaded " + loaded.toPrecision(5) + " Megabytes of " + total.toPrecision(5);//String output
    var percent = (event.loaded / event.total) * 100;//Get percentage of upload progress
    _("progressBar").value = Math.round(percent);//Round value to solid
    _("status").innerHTML = Math.round(percent) + "% uploaded";//String output
}
function completeHandler(event) {
    _("status").innerHTML = event.target.responseText;//Build and show response text
    _("progressBar").value = 0;//Set progress bar to 0
    document.getElementById('progressDiv').style.display = 'none';//Hide progress bar
}
function errorHandler(event) {
    _("status").innerHTML = "Upload Failed";//Switch status to upload failed
}
function abortHandler(event) {
    _("status").innerHTML = "Upload Aborted";//Switch status to aborted
}
</script>
</body>
</html>