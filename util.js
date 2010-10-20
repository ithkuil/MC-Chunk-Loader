Number.prototype.mod = function(n) {
  return ((this % n) + n) % n;
};


function baseConverter(number, ob, nb) {
  if (typeof(number) === 'undefined')     
    return 0;
  number = number.toString();
  // Created 1997 by Brian Risk.  http://brianrisk.com
  number = number.toUpperCase();
  var list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  var dec = 0;
  for (var i = 0; i <= number.length; i++) {
    dec += (list.indexOf(number.charAt(i))) * (Math.pow(ob, (number.length - i - 1)));
  }
  number = "";
  var magnitude = Math.floor((Math.log(dec)) / (Math.log(nb)));
  for (var i = magnitude; i >= 0; i--) {
    var amount = Math.floor(dec / Math.pow(nb, i));
    number = number + list.charAt(amount);
    dec -= amount * (Math.pow(nb, i));
  }
  return number;
}

//http://stackoverflow.com/questions/1240408/reading-bytes-from-javascript-string
//answer at top by Borgar (with slight modification to make part faster)
//http://borgar.net/

function stringToBytes(str) {
  var ch, st, re = [];
  var ilen = str.length;
  for (var i = 0; i < ilen; i++) {
    re.push(str.charCodeAt(i)); // get char
  }
  // return an array of bytes
  return re;
}



function getIntAt(arr, offs) {
  return (arr[offs + 0] << 24) +
  (arr[offs + 1] << 16) +
  (arr[offs + 2] << 8) +
  arr[offs + 3];
}

