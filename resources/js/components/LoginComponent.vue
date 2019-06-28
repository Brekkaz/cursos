<template>
  <div class="col-md-4 offset-md-4 mt-5">

    <div class="card">
      <div class="card-header bg-primary text-white">
        <h1 class="my-3 text-center">iniciar sesion</h1>
      </div>
      
      <div class="card-body">
        <form action="">
          <div class="form-group">
            <label for="">Email</label>
            <input v-model="email" type="email" class="form-control" placeholder="ingrese email">
          </div>
          <div class="form-group">
            <label for="">Contraseña</label>
            <input v-model="password" type="password" class="form-control" placeholder="ingrese contraseña">
          </div>
          <button @click="login()" type="button" class="btn btn-primary">Enviar</button>
        </form>
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    mounted() {
      console.log('Component mounted.')
    },
    data() {
      return {
        email:"sdasd",
        password:"asd"
      }
    },
    methods: {
      login: function() {
        axios.post('/api/login', {
          email: this.email,
          password: this.password
        })
        .then(function (res) {
          alert(JSON.stringify(res.data));
        })
        .catch(function (err) {
          console.log(err);
        });
      }
    }
  }
</script>
