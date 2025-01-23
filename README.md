# Perseu AI - Virtual Assistant for Daily Tasks

**Perseu AI** é um assistente virtual inteligente projetado para otimizar e simplificar tarefas do dia a dia. Desenvolvido com tecnologias modernas de IA, ele visa melhorar a produtividade ao oferecer soluções inteligentes para o gerenciamento de atividades diárias, automação de processos repetitivos e acesso rápido a informações essenciais. Seja para gerenciar compromissos, responder perguntas ou ajudar com automações básicas, o Perseu AI é a ferramenta ideal para quem busca praticidade nas operações diárias.

## Funcionalidades

- Automação e gerenciamento de tarefas
- Lembretes inteligentes e notificações
- Recomendações personalizadas
- Processamento de linguagem natural (NLP) para melhor interação
- Integração com outras ferramentas e serviços

## Tecnologias Utilizadas

- Inteligência Artificial (IA)
- Processamento de Linguagem Natural (NLP)
- Integração com a Nuvem

## Configuração do Ambiente Local

Siga os passos abaixo para configurar o projeto localmente.

### Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/Pedroasilva/perseu-ai.git
   ```

2. Navegue até o diretório do projeto:
   ```bash
   cd perseu-ai
   ```

3. Configure os serviços backend:
- Navegue até a pasta `backend`:
  ```bash
  cd backend
  ```
- Construa os containers:
  ```bash
  docker-compose build
  ```
- Inicie os serviços:
  ```bash
  docker-compose up -d
     ```

4. Configure a API do WhatsApp:
- Navegue até a pasta `whatsapp-api`:
  ```bash
  cd ../whatsapp-api
  ```
- Construa os containers:
  ```bash
  docker-compose build
  ```
- Inicie os serviços:
  ```bash
  docker-compose up -d
     ```

Após seguir esses passos, a aplicação estará pronta e acessível.

## Contribuição

1. Faça um fork do repositório.
2. Crie um branch para sua funcionalidade (`git checkout -b nome-da-funcionalidade`).
3. Realize suas alterações e faça commits (`git commit -am 'Adiciona nova funcionalidade'`).
4. Envie as alterações para o repositório remoto (`git push origin nome-da-funcionalidade`).
5. Crie um Pull Request para revisão.

## Licença

Distribuído sob a licença MIT. Consulte o arquivo `LICENSE` para mais informações.