# moviesBlog API for Vue Later

# Template Symfony 6 + Vue 3

   This is a template to get started on a new Symfony/Vue3 project, everything is already set up and good to go.

## Symfony Setup

```symfony
composer install
```

### Compile and Hot-Reload for Development

```symfony
symfony serve
```

## Vue Setup

```vue
npm install
```

### OR

```vue
yarn install
```

### Compile and Hot-Reload for Development

```vue
npm run watch
```

### run server
```
composer create-project symfony/skeleton movieBlog-server
cd movieBlog-server
php -S 127.0.0.1:8000 -t public
```


### run client
```
npm install -g @vue/cli
vue create movieBlog-client
cd movieBlog-client
npm serve
```
