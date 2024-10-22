## Pré-requisitos

- [Docker](https://www.docker.com/get-started) instalado na sua máquina
- [Docker Compose](https://docs.docker.com/compose/install/) instalado

## Como Executar o Projeto

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/renanholler/magazord-teste.git  
   cd magazord-teste
   ```

2. **Inicie os contêineres com Docker Compose:**

   ```bash
   docker-compose up --build
   ```
   *Isso irá construir as imagens necessárias e iniciar os serviços definidos.*

3. **Acesse a aplicação:**

   - **Frontend:** [http://localhost:5173](http://localhost:5173)
   - **API:** [http://localhost:8000](http://localhost:8000)
