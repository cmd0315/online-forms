$( document ).ready(function() {
    //alert('hi');
});

function addAccount(number) {
	var divID = "acct_div" + number;
	//alert(divID);
	document.getElementById(divID).style.display = "block";
}