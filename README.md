# 🏍️ Sistema de Manutenção de Motos - Tainan Motos

Este projeto é um sistema web desenvolvido como trabalho prático para a disciplina **Banco de Dados I** do 3º semestre de Ciência da Computação no IFRS Ibirubá. O objetivo é digitalizar e organizar os registros de manutenções da oficina **Tainan Motos**, tornando o atendimento mais ágil e eficiente.

## 📌 Problemas solucionados

- 📄 **Registros Manuais**: elimina dados em papel, reduzindo perdas e desorganização.
- ⏱️ **Atendimento Ineficiente**: cadastro rápido sem interromper o trabalho do mecânico.
- 📚 **Falta de Histórico**: mantém histórico de serviços e peças trocadas.
- ✅ **Menos Erros**: validações e controle de duplicidade.
- 📊 **Relatórios**: organização por cliente, moto e serviço.

## 🛠️ Tecnologias utilizadas

- **Laravel**: Framework PHP para desenvolvimento web.
- **Blade**: Template engine do Laravel para o front-end.
- **MySQL**: Banco de dados relacional.
- **PHP**: Linguagem principal do back-end.
- **JavaScript & CSS**: Interatividade e estilização.
- **jsPDF**: Geração de relatórios em PDF.
- **Telescope**: Debug de funções no Laravel.

## 👥 Público-alvo

- Oficinas de motos que precisam documentar manutenções.
- Mecânicos que desejam mais agilidade no atendimento.
- Profissionais que buscam manter histórico e controle de serviços.
- Oficinas que querem reduzir registros manuais.

## 🗄️ Modelagem do Banco

Principais tabelas:

- `usuario(cpf, nome, senha, email, telefone, tipo)`
- `fabricante(codigo, nome)`
- `modelo(codigo, nome, cod_fabricante)`
- `peca(codigo, nome, preco, cod_modelo)`
- `moto(codigo, placa, ano, cpf_usuario, cod_modelo)`
- `servico(codigo, data_abertura, data_fechamento, descricao, valor, quilometragem, situacao, descricao_manutencao, cod_moto)`
- `maodeobra(codigo, nome, valor)`
- `servico_peca(cod_servico, cod_peca, quantidade)`
- `servico_maodeobra(cod_servico, cod_maodeobra, quantidade)`

## ✨ Funcionalidades principais

- Cadastro de usuários, motos, peças e mão de obra.
- Solicitação e gerenciamento de manutenções.
- Histórico detalhado de serviços realizados.
- Pesquisa, alteração e exclusão de componentes.
- Relatórios por cliente, moto ou serviço.
- Exportação de relatórios em PDF.

## 💡 Futuras melhorias

- Melhor proteção contra SQL Injection.
- Opção de redefinição de senha.
- Login via WhatsApp.
- Integração com NFE (Nota Fiscal Eletrônica).
- Integração com PWA para uso offline.
- Layout mais responsivo.
- Inclusão de eventos de motocross.
- Expansão da base de clientes.

