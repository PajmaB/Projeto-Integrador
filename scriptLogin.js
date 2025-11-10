const form = document.getElementById("loginForm");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;
  const tipo = document.getElementById("tipo").value;

  try {
    const response = await fetch("php/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email, senha, tipo }),
    });

    const data = await response.json();

    if (data.success) {
      alert(data.message);
      // Redireciona para página protegida, por exemplo dashboard.html
      window.location.href = "index.html";
    } else {
      alert(data.error);
    }
  } catch (err) {
    alert("Erro ao tentar fazer login.");
  }
});
