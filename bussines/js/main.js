var homeBtn=document.getElementById("home");
var detailsBtn=document.getElementById("details");

var homeDiv=document.getElementById("homeDiv");
var detailsDiv=document.getElementById("detailsDiv");

homeBtn.onclick=function(){
    homeDiv.style.display="flex";
    detailsDiv.style.display="none";
}
detailsBtn.onclick=function(){
    homeDiv.style.display="none";
    detailsDiv.style.display="flex";
}

// document.getElementById("homeBtn").onclick=function(){
//     document.getElementById("homeDiv").style.display="flex";
//     document.getElementById("detailsDiv").style.display="none";
// }
// document.getElementById("detailsBtn").onclick=function(){
//     document.getElementById("homeDiv").style.display="none";
//     document.getElementById("detailsDiv").style.display="fle";
// }