

//Pour afficher la date du jour dans le champ calendrier du formulaire de réservation


function afficheDate() {  //cette fonction pour afficher la date                       
  var dateSysteme = new Date();
  var jour = ('0' + dateSysteme.getDate()).slice(-2);
  var mois = ('0' + (dateSysteme.getMonth() + 1)).slice(-2); //le numero du mois de janvier est 0
  var annee = dateSysteme.getFullYear();

var aujourdhui = new Date();   
document.getElementById('dateDuJour').valueAsDate = aujourdhui;
 }

 
 //Pour cacher le champ heure non séléctionné dans le formulaire de réservation
 
 function handleChange(event){
  
  document.querySelectorAll('.block').forEach((form)=>{
    form.classList.toggle('hidden');
    
  })
}
 


































