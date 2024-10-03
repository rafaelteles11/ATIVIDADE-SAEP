<?php
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAEP SIMULADO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <h2 class="logo">SAEP Simulado</h2>
        </div>
    </nav>

    <!-- Container Principal -->
    <div class="container">
        <h1>Cadastro de Alunos</h1>
        
        <!-- Formulário de cadastro de alunos -->
        <form action="cadastro.php" method="POST" class="form-cadastro">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="idade">Idade:</label>
            <input type="number" name="idade" id="idade" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="curso">Curso:</label>
            <input type="text" name="curso" id="curso" required>

            <button type="submit">Cadastrar</button>
        </form>

        <!-- Formulário de pesquisa -->
        <form method="GET" action="" class="form-pesquisa">
            <?php
            // Verifica se foi feita uma pesquisa e armazena o termo
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            ?>
            <input type="text" name="pesquisa" placeholder="Pesquisar por nome ou curso" value="<?php echo htmlspecialchars($pesquisa); ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <!-- Tabela de Alunos -->
        <h2>Alunos Cadastrados</h2>
        <table class="table-alunos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Email</th>
                    <th>Curso</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta padrão ou com base na pesquisa
                if ($pesquisa) {
                    // Prepara a consulta de pesquisa com parâmetros de nome ou curso
                    $sql = "SELECT * FROM alunos WHERE nome LIKE '%$pesquisa%' OR curso LIKE '%$pesquisa%'";
                } else {
                    // Consulta padrão para listar todos os alunos
                    $sql = "SELECT * FROM alunos";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Exibe os alunos cadastrados
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nome']}</td>
                                <td>{$row['idade']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['curso']}</td>
                                <td>
                                    <a href='editar.php?id={$row['id']}' class='btn-edit'>Editar</a>
                                    <a href='deletar.php?id={$row['id']}' class='btn-delete'>Excluir</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum aluno encontrado</td></tr>";
                }
                ?>
            </tbody>

        </table>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 SAEP Simulado. Todos os direitos reservados.</p>
            <ul class="footer-links">
                <li><a href="#">Política de Privacidade</a></li>
                <li><a href="#">Termos de Uso</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
