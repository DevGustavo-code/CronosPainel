# ⏱️ Cronos Painel

**Cronos Painel** é um sistema web de produtividade e controle de estudos, desenvolvido em **PHP puro + MySQL**, com foco em simplicidade, organização e experiência do usuário.  
O projeto permite registrar horas de estudo, definir metas, acompanhar progresso por gráficos e gerenciar objetivos pessoais.

> 🎯 Ideal para estudantes, autodidatas e desenvolvedores que desejam um painel simples e funcional.

---

## 📸 Preview
> Interface moderna com **Dark / Light Theme**, gráficos dinâmicos e modais interativos.

---

## 🚀 Funcionalidades

- ✅ Autenticação de usuários (Login / Registro / Logout)
- 🔐 Recuperação de senha com token seguro
- ⏳ Registro de horas de estudo
- 📊 Gráfico de produtividade (Semana / Mês / Ano)
- 🎯 Definição de metas por período
- 🗂️ Planejamento de objetivos (CRUD)
- 🌗 Alternância entre tema Dark e Light (persistente)
- 🛡️ Proteção por sessão
- 🧼 Código organizado e documentado

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8+ (PDO)**
- **MySQL**
- **HTML5**
- **CSS3 (variáveis + temas)**
- **JavaScript (Vanilla)**
- **Chart.js**
- **XAMPP / Apache**

---

## 📂 Estrutura do Projeto

```txt
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
