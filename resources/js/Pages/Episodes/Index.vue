<template>
    <div class="mx-8 p-4 bg-white rounded shadow" >
        <div class="text-sm text-gray-500">Mise en ligne par {{course.user.name}}</div>
        <div class="flex justify-between items-center">
            <div class="text-4xl">{{course.title}}</div>
            <div class="text-sm text-gray-400">{{course.episodes_count}} episodes</div>
        </div>
        <div class="text-sm text-gray-500">{{course.description}}</div>
        <a class="bg-indigo-500 text-white px-2 py-1 mt-3 text-sm rounded hover:bg-indigo-800 inline-block" :href="'course/'+course.id">Voir la formation</a>
    </div>
</template>
<script>
export default {
    data()
    {
        return{}
    },
    props:['course'],
    mounted()
    {
        console.log(this.course);
    },
}
</script>