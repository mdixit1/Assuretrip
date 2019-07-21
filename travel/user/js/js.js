function iFrameOn(){richtextfield.document.designMode = 'On';	}	
function iBold(){	richtextfield.document.execCommand('bold',false,null);	}

function iUnorderedList(){	richtextfield.document.execCommand("insertOrderedList",false,"newOL"); }
function iOrderedList(){ richtextfield.document.execCommand("insertUnorderedList",false,"newUL"); }
function iLink(){ var store = prompt("Enter the URL for this link:", "http://");
					richtextfield.document.execCommand("CreateLink",false, store); }
function iUnLink(){	richtextfield.document.execCommand("Unlink",false,null); }
function iCode(){ richtextfield.document.execCommand("code",false,null); }


function submit_form(){	var  theform = document.getElementById("myform");
		 theform.elements["mytextarea"].value = window.frames['richtextfield'].document.body.innerHTML;
		 theForm.submit(); }