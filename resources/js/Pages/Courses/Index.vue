<template>
<app-layout>
    <template #header>
        Liste des formations
    </template>
    <div >
        <course class="my-3" v-for="course in courseList" v-bind:key="course.id" :course="course" ></course>
    </div>
</app-layout>
</template>
<script>
import AppLayout from './../../Layouts/AppLayout.vue';
import Course from './../Courses/Course.vue';
export default {
    components: {AppLayout,Course},
    props:['courses'],
    mounted() {
       // console.log(this.courseList);
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