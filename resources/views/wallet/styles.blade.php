
#glbreadcrumbs-two{
	  /* Clear floats */
	  overflow: hidden;
	  width: 100%;
	   margin: 0;
	  padding: 0;
	  list-style: none;
	}
	
	#glbreadcrumbs-two li{
	  float: left;
	  margin: 0 .5em 0 1em;
	}
	
	#glbreadcrumbs-two a{
	  background: #50d38a;
	  padding: .7em 1em;
	  float: left;
	  text-decoration: none;
	  color: #ffffff;
	  text-shadow: none; 
	  position: relative;
	}
	
	#glbreadcrumbs-two a:hover{
	  background: #e0eed8;	  
	}
	
	#glbreadcrumbs-two a::before{
	  content: "";
	  position: absolute;
	  top: 50%; 
	  margin-top: -1.5em;   
	  border-width: 1.5em 0 1.5em 1em;
	  border-style: solid;
	  border-color: #50d38a #50d38a #50d38a transparent;
	  left: -1em;
	}
	
	#glbreadcrumbs-two a:hover::before{
	  border-color: #e0eed8 #e0eed8 #e0eed8 transparent;
	}
	
	#glbreadcrumbs-two a::after{
	  content: "";
	  position: absolute;
	  top: 50%; 
	  margin-top: -1.5em;   
	  border-top: 1.5em solid transparent;
	  border-bottom: 1.5em solid transparent;
	  border-left: 1em solid #50d38a;
	  right: -1em;
	}
	
	#glbreadcrumbs-two a:hover::after{
	  border-left-color: #e0eed8;
	}
	
	#glbreadcrumbs-two .current,
	#glbreadcrumbs-two .current:hover{
	  font-weight: bold;
	  background: none;
	}
	
	#glbreadcrumbs-two .current::after,
	#glbreadcrumbs-two .current::before{
	  content: normal;
	}

	#glbreadcrumbs-two .a{
		background: #D6D4D5;
		padding: .7em 1em;
		float: left;
		text-decoration: none;
		color: #6B6567;
		text-shadow: 1px 1px 1px rgba(255,255,255,.5); 
		position: relative;
	  }
	  
	  #glbreadcrumbs-two .a:hover{
		background: #E6E1E3;	  
	  }
	  
	  #glbreadcrumbs-two .a::before{
		content: "";
		position: absolute;
		top: 50%; 
		margin-top: -1.5em;   
		border-width: 1.5em 0 1.5em 1em;
		border-style: solid;
		border-color: #D6D4D5 #D6D4D5 #D6D4D5 transparent;
		left: -1em;
	  }
	  
	  #glbreadcrumbs-two .a:hover::before{
		border-color: #E6E1E3 #E6E1E3 #E6E1E3 transparent;
	  }
	  
	  #glbreadcrumbs-two .a::after{
		content: "";
		position: absolute;
		top: 50%; 
		margin-top: -1.5em;   
		border-top: 1.5em solid transparent;
		border-bottom: 1.5em solid transparent;
		border-left: 1em solid #D6D4D5;
		right: -1em;
	  }
	  
	  #glbreadcrumbs-two .a:hover::after{
		border-left-color: #E6E1E3;
	  }