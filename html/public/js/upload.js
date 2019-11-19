Dropzone.autoDiscover = false;
var dropzone_default = new Dropzone(".dropzone", {
    url: '/upload',
    maxFiles: 1,
    dictMaxFilesExceeded: 'Only 1 Xml can be uploaded',
    acceptedFiles: '.xml',
    maxFilesize: 3, // in Mb
    addRemoveLinks: true,
    init: function () {
        this.on("maxfilesexceeded", function (file) {
            this.removeFile(file);
        });
        this.on("sending", function (file, xhr, formData) {
            // send additional data with the file as POST data if needed.
            // formData.append("key", "value");  
        });
        this.on("success", function (file, response) {
            if (response.uploaded) {
//                alert('File Uploaded: ' + response.fileName);
            }
        });
        this.on("error", function (file, errorMessage, xhr) {
            this.removeFile(file);
            alert(errorMessage);
        });
        this.on("complete", function (file) {
            var response = JSON.parse(file.xhr.response);
            var newNode = document.createElement('button');
            newNode.className = 'btn btn-primary btn-xs downloadbtn';
            newNode.onclick  = () => { processXml(response.fileName); };
            newNode.innerHTML = 'Process XML';
            file.previewTemplate.appendChild(newNode);
        });
    }
});

function processXml(filename) {
    $.ajax({
    url: `/process-xml/${filename}`,
    type: 'GET',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function(data) {
      (data.success == true) ? alert('Xml process successfully') : alert(data.error);
    },
    error: function(error) {
      alert(error);
    }
  });
}
