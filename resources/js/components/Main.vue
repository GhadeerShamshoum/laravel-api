<template>
  <div>
    <div>
      <div v-for="(post, index) in posts" :key="index">
        <h1>{{post.title}}</h1>
        <h3>{{post.content}}</h3>
        

      </div>
    </div>


  </div>
</template>

<script>

export default {
    name: "Main",

    data(){
      return{
        posts: []

      }
    },
    created() {
      axios
      .get("/api/posts")
      .then((response)=> {
        this.posts = response.data

      })
    }

    
}
</script>

<style scoped>

</style>