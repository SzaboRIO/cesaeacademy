// scripts.js

//função para alternar entre os formulários de login e registo
function toggleForms() {

    //obtém os elementos dos formulários de login e registo usando seus IDs
  var loginForm = document.getElementById('loginForm');
  var registerForm = document.getElementById('registerForm');
  
  // Verifica o estado atual dos formulários e alterna entre eles
  if (loginForm.style.display === 'none') {
    loginForm.style.display = 'block';  // Exibe o formulário de login
    registerForm.style.display = 'none';  // Oculta o formulário de registro
  } else {
    loginForm.style.display = 'none';  // Oculta o formulário de login
    registerForm.style.display = 'block';  // Exibe o formulário de registro
  }
}