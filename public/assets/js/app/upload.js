function el(id){return document.getElementById(id);}

function readImage() {
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
             el("img").src = e.target.result;
             // el("base").innerHTML = e.target.result;
             // document.cookie="base64="+e.target.result;
             // el.("base64").innerHTML = e.target.result;
             document.getElementById("base64").value = e.target.result;
             // window.location = window.location.href + "/upload";
        };       
        FR.readAsDataURL( this.files[0] );
    }
}

el("inputfile").addEventListener("change", readImage, false);