<?php
include 'db.php';

// Verifica se um ID de aluno foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Seleciona o aluno do banco de dados
    $sql = "SELECT * FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o aluno existe
    if ($result->num_rows > 0) {
        $aluno = $result->fetch_assoc();
    } else {
        echo "Aluno não encontrado.";
        exit;
    }
}

// Verifica se o formulário de edição foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];

    // Atualiza os dados do aluno no banco de dados
    $sql = "UPDATE alunos SET nome = ?, idade = ?, email = ?, curso = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisii", $nome, $idade, $email, $curso, $id);

    if ($stmt->execute()) {
        echo "Aluno atualizado com sucesso!";
        header("Location: index.php"); // Redireciona para a página principal após editar
        exit;
    } else {
        echo "Erro ao atualizar aluno.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Aluno</h1>

        <!-- Formulário de edição de alunos -->
        <form action="editar.php" method="POST" class="form-editar">
            <input type="hidden" name="id" value="<?php echo $aluno['id']; ?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?php echo $aluno['nome']; ?>" required>

            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" value="<?php echo $aluno['idade']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $aluno['email']; ?>" required>

            <label for="curso">Curso:</label>
            <input type="text" name="curso" id="curso" value="<?php echo $aluno['curso']; ?>" required>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>