const validation = new JustValidate("#signup");

const errorBox = document.createElement("div");
errorBox.id = "form-error";
errorBox.style.color = "red";
errorBox.style.marginBottom = "10px";
document.querySelector("#signup").prepend(errorBox);

validation
  .addField("#name", [{ rule: "required" }])
  .addField("#email", [
    { rule: "required" },
    { rule: "email" }
  ])
  .addField("#birthdate", [{ rule: "required" }])
  .addField("#password", [
    { rule: "required" },
    { rule: "password" }
  ])
  .addField("#password_confirmation", [
    {
      validator: (value, fields) => {
        return value === fields["#password"].elem.value;
      },
      errorMessage: "As senhas não coincidem"
    }
  ])
  .onFail(() => {
    errorBox.textContent = "⚠️ Por favor, preencha todos os campos corretamente.";
  })
  .onSuccess(() => {
    errorBox.textContent = ""; // limpa a mensagem de erro se tudo estiver ok
    document.getElementById("signup").submit();
  });
