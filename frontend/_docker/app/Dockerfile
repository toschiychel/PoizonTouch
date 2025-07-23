# ------ builder ------
FROM node:18-alpine AS builder
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm ci
COPY . .

# ✅ Собираем и копируем ассеты в нужные места
RUN npm run build \
  && mkdir -p dist/assets \
  && cp -r src/assets/* dist/assets/ \
  && mkdir -p dist/src/assets \
  && cp -r src/assets/* dist/src/assets/

# ------ production ------
FROM nginx:stable-alpine
COPY --from=builder /app/dist /usr/share/nginx/html
COPY _docker/nginx/frontend.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
