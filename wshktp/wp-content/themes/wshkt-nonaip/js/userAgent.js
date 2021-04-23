var ua = navigator.userAgent;

if(ua.indexOf('iPhone') > 0 || ua.indexOf('iPod') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0){
//smartphone
document.write('<link rel="stylesheet" href="css/style_sp.css">');

}else{
//PC
document.write('<link rel="stylesheet" href="css/style.css">');

}