function displayModal(modal){
  let modalId;
  let filter = document.getElementById('hidden');
  if(modal == "name"){
    modalId = document.getElementById('changeNameModal');
    modalId.style.display = "flex";
    filter.style.display = "block";
  } else if(modal == "username"){
    modalId = document.getElementById('changeUsernameModal');
    modalId.style.display = "flex";
    filter.style.display = "block";
  } else if(modal == "password"){
    modalId = document.getElementById('changePasswordModal');
    modalId.style.display = "flex";
    filter.style.display = "block";
  } else if(modal == "rPassword"){
    modalId = document.getElementById('resetPasswordModal');
    modalId.style.display = "flex";
    filter.style.display = "block";
  } else {
    console.warn("Please do not change any of the entities on this site or they will not function properly. Thank you. ~ Dalton (Developer)")
    filter.style.display = "none";
    modalId.style.display = "none";
  }
}

function closeModal() {
  document.getElementById('changeNameModal').style.display = "none";
  document.getElementById('changeUsernameModal').style.display = "none";
  document.getElementById('changePasswordModal').style.display = "none";
  document.getElementById('resetPasswordModal').style.display = "none";
  document.getElementById('hidden').style.display = "none";
  console.log("All modals closed");
}