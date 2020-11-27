<template>
<app-layout>
    <!-- <template slot="header">
        Liste des formations
    </template> -->
    <template #header>
        Liste des formations
    </template>
    <div >
        <episode class="my-3" v-for="course in courseList" v-bind:key="course.id" :course="course" ></episode>
    </div>
</app-layout>
</template>
<script>
import AppLayout from './../../Layouts/AppLayout.vue';
import Episode from './../Episodes/Index.vue';
export default {
    components: {AppLayout,Episode},
    props:['courses'],
    mounted() {
        console.log(this.courseList);
    },
    data(){
        return {
            courseList:this.courses,
        };},
        methods: {
            formatDate(date)
            {
                return (new Date(date)).toLocaleDateString()+"    "+(new Date(date)).toLocaleTimeString();
            }
        }
}
</script>