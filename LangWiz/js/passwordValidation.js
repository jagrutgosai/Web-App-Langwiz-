
    function validatePassword()
    {
    var p1 =  document.getElementById("password1").value;
    var p2 =  document.getElementById("password2").value;
    
        if(p1 == p2 && p1!="" && p2!=""){
        document.getElementById("errorMatch").innerHTML="Paswords Match"; 
        document.getElementById("errorMatch").style.color='green'; 
        
			if (/^[A-Z](?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{4,10}$/.test(p1) == true){
				document.getElementById("errorPassw").innerHTML="";
				document.getElementById('createacc').disabled = false;				
			}else{
				 document.getElementById("errorPassw").innerHTML="\nPassword must be between 4 to 10 chars\nstart with uppercase\nand contain at least other uppercase letter, one lowercase letter, and one number"; 
       			 document.getElementById("errorPassw").style.color='red'; 
			}
        
        }
		
        else if(p1=="" && p2==""){document.getElementById("errorMatch").innerHTML=""; }
        else{
		document.getElementById("errorPassw").innerHTML="";	 
        document.getElementById("errorMatch").innerHTML="Paswords Not Match"; 
        document.getElementById("errorMatch").style.color='red'; 
        document.getElementById('createacc').disabled = true;}

    }
