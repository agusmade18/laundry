// PROGRAM ONLINE SHOP
// ===================
// Author Detail :
// nama    : I Made Agus Suyasa
// email   : rubyruck@gmail.com
// tgl.mulai : 3 Januari 2018



function convToRp(val)
{
	var result = "Rp " + val.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
	return result;
}