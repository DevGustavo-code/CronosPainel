<h1>⏱️ Cronos Painel</h1>

<p>
  <strong>Cronos Painel</strong> é um sistema web de produtividade e controle de estudos,
  desenvolvido em <strong>PHP puro + MySQL</strong>, com foco em simplicidade,
  organização e boa experiência do usuário.
</p>

<p>
  O sistema permite <strong>registrar horas de estudo</strong>,
  <strong>definir metas</strong>, <strong>acompanhar o progresso por gráficos</strong>
  e <strong>gerenciar objetivos pessoais</strong> em um painel moderno e funcional.
</p>

<blockquote>
  🎯 Ideal para estudantes, autodidatas e desenvolvedores que desejam um projeto prático
  para estudo ou portfólio.
</blockquote>

<hr>

<h2>📸 Preview</h2>

<p>Interface moderna com <strong>Dark / Light Theme</strong>, gráficos dinâmicos e modais interativos.</p>

<img width="100%" alt="Dashboard Dark"
     src="https://github.com/user-attachments/assets/a5969010-174a-4490-9c43-d5a7d5b606c0" />

<br><br>

<img width="100%" alt="Dashboard Light"
     src="https://github.com/user-attachments/assets/48d70ca0-c11c-4e33-878f-a4ed0646e16f" />

<br><br>

<img width="100%" alt="Modais"
     src="https://github.com/user-attachments/assets/49a960a5-c3fa-4353-9f39-325989c16e18" />

<hr>

<h2>🚀 Funcionalidades</h2>

<ul>
  <li>✅ Autenticação de usuários (Login / Registro / Logout)</li>
  <li>🔐 Recuperação de senha com token seguro</li>
  <li>⏳ Registro de horas de estudo</li>
  <li>📊 Gráfico de produtividade (Semana / Mês / Ano)</li>
  <li>🎯 Definição de metas por período</li>
  <li>🗂️ Planejamento de objetivos (CRUD)</li>
  <li>🌗 Alternância entre tema Dark e Light (persistente)</li>
  <li>🛡️ Proteção por sessão</li>
  <li>🧼 Código organizado e documentado</li>
</ul>

<hr>

<h2>🛠️ Tecnologias Utilizadas</h2>

<ul>
  <li><strong>PHP 8+</strong> (PDO)</li>
  <li><strong>MySQL</strong></li>
  <li><strong>HTML5</strong></li>
  <li><strong>CSS3</strong> (variáveis e temas)</li>
  <li><strong>JavaScript (Vanilla)</strong></li>
  <li><strong>Chart.js</strong></li>
  <li><strong>XAMPP / Apache</strong></li>
</ul>

<hr>

<h2>⚙️ Instalação e Configuração</h2>

<h3>1️⃣ Clonar o repositório</h3>

<pre><code>git clone https://github.com/seu-usuario/cronos-painel.git</code></pre>

<h3>2️⃣ Configurar o banco de dados</h3>

<p>
  Crie um banco de dados no MySQL (exemplo: <strong>cronos</strong>) e importe o arquivo:
</p>

<pre><code>database/schema.sql</code></pre>

<h3>3️⃣ Configurar a conexão</h3>

<p>Edite o arquivo <code>config/db.php</code>:</p>

<pre><code>
$pdo = new PDO(
  "mysql:host=localhost;dbname=cronos;charset=utf8",
  "root",
  ""
);
</code></pre>

<h3>4️⃣ Executar o projeto</h3>

<ul>
  <li>Coloque a pasta dentro do <code>htdocs</code></li>
  <li>Inicie o Apache e o MySQL</li>
  <li>Acesse no navegador:</li>
</ul>

<pre><code>http://localhost/CronosPainel/public</code></pre>

<hr>

<h2>🔐 Segurança</h2>

<ul>
  <li>Hash de senha com <code>password_hash()</code></li>
  <li>Tokens seguros com <code>random_bytes()</code></li>
  <li>Expiração de links de recuperação</li>
  <li>Proteção contra SQL Injection (PDO + Prepared Statements)</li>
  <li>Controle de sessão</li>
</ul>

<hr>

<h2>🧠 Decisões de Arquitetura</h2>

<ul>
  <li>PHP puro para melhor entendimento da base</li>
  <li>Separação por camadas (public / controllers / config)</li>
  <li>CSS com variáveis globais para temas</li>
  <li>JavaScript desacoplado</li>
  <li>Banco relacional simples e extensível</li>
</ul>

<hr>

<h2>🐞 Problemas Comuns</h2>

<ul>
  <li>
    <strong>❌ Table password_resets doesn't exist</strong><br>
    → Importar corretamente o arquivo <code>schema.sql</code>
  </li>
  <li>
    <strong>❌ Tema não persiste</strong><br>
    → Limpar cookies ou testar em aba anônima
  </li>
  <li>
    <strong>❌ Erro de sessão</strong><br>
    → Verificar <code>session_start()</code> no topo dos arquivos
  </li>
</ul>

<hr>

<h2>📈 Próximas Melhorias (Roadmap)</h2>

<ul>
  <li>📧 Envio real de e-mail (SMTP)</li>
  <li>📱 Responsividade mobile</li>
  <li>📅 Calendário de estudos</li>
  <li>📌 Categorias de matérias</li>
  <li>👤 Perfil do usuário</li>
  <li>🧪 Testes automatizados</li>
</ul>

<hr>

<h2>👨‍💻 Autor</h2>

<p>
  <strong>Gustavo</strong><br>
  🎓 Estudante de Análise e Desenvolvimento de Sistemas<br>
  💻 Foco em Back-end, Sistemas Web e Projetos práticos<br>
  🔗 Projeto desenvolvido para estudo e portfólio
</p>

<hr>

<h2>📄 Licença</h2>

<p>
  Este projeto é de uso livre para fins educacionais.<br>
  Sinta-se à vontade para estudar, modificar e evoluir 🚀
</p>

<hr>

<h2>📂 Estrutura do Projeto</h2>

<pre><code>
CronosPainel/
├── assets/
│   ├── css/
│   │   ├── dashboard.css   # Estilos da dashboard
│   │   └── index.css       # Estilos de login/registro
│   │
│   ├── img/
│   │   └── image.png       # Assets visuais
│   │
│   └── js/
│       └── dashboard.js    # Tema, modais e interações
│
├── config/
│   └── db.php              # Conexão PDO com MySQL
│
├── controllers/
│   └── auth.php            # Autenticação e validações
│
├── database/
│   └── schema.sql          # Estrutura completa do banco
│
├── public/
│   ├── index.php           # Login
│   ├── register.php        # Registro
│   ├── recover.php         # Recuperação de senha
│   ├── reset.php           # Redefinição de senha
│   ├── dashboard.php       # Painel principal
│   └── logout.php          # Encerramento de sessão
│
├── README.md
└── structure.txt
</code></pre>
