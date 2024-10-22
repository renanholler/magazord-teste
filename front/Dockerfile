# Use uma imagem oficial do Node.js como base
FROM node:18

# Define o diretório de trabalho no contêiner
WORKDIR /usr/src/app

# Copia os arquivos de package.json e package-lock.json para o diretório de trabalho
COPY package.json ./

# Instala as dependências
RUN npm install

# Copia o restante dos arquivos da aplicação
COPY . .

# Exponha a porta usada pelo Vite
EXPOSE 5173

# Comando para iniciar a aplicação em modo de desenvolvimento
CMD ["npm", "run", "dev"]