const formR = document.getElementById("registerForm");

// Quando o botão "Cadastrar" for clicado (submit do form)
formR.addEventListener("submit", async (e) => {
  e.preventDefault(); // impede o reload da página

  const nome = document.getElementById("nome").value;
  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;
  const tipo = document.getElementById("tipo").value;

  try {
    const response = await fetch("php/register.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nome, email, senha, tipo }),
    });

    const data = await response.json();

    if (data.message) {
      alert(data.message);
      window.location.href = "indexLogin.html"; // redireciona se deu certo
    } else {
      alert(data.error);
    }
  } catch (error) {
    alert("Erro ao se registrar. Tente novamente.");
  }
});

const formL = document.getElementById("loginForm");

// Quando o botão "Entrar" for clicado (submit do form)
formL.addEventListener("submit", async (e) => {
  e.preventDefault(); // impede o reload da página

  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;

  try {
    const response = await fetch("php/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email, senha}),
    });

    const data = await response.json();

    if (data.message) {
      alert(data.message);
      window.location.href = "index.html"; // redireciona se deu certo
    } else {
      alert(data.error);
    }
  } catch (error) {
    alert("Erro ao Logar. Tente novamente.");
  }
});
