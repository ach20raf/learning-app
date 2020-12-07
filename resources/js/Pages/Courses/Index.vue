<template>
	<app-layout>
		<template #header> Liste des formations </template>
		<section>
			<course
				class="my-3"
				v-for="course in courseList"
				v-bind:key="course.id"
				:course="course"
			></course>
			<inertia-link
				:href="link.url"
				v-for="(link, index) in this.courses.links"
				v-bind:key="index"
				class="text-indigo-700 m-5 pb-6 border-gray"
			>
				<span
					v-bind:class="{ 'text-red-700': link.active }"
					v-html="link.label"
				>
				</span>
			</inertia-link>
		</section>
	</app-layout>
</template>
<script>
	import AppLayout from "./../../Layouts/AppLayout.vue";
	import Course from "./../Courses/Course.vue";
	export default {
		components: { AppLayout, Course },
		props: ["courses"],
		mounted() {
			// console.log(this.courseList);
		},
		data() {
			return {
				courseList: this.courses.data,
				spades: "&raquo;",
			};
		},
		methods: {
			formatDate(date) {
				return (
					new Date(date).toLocaleDateString() +
					"    " +
					new Date(date).toLocaleTimeString()
				);
			},
			formatLink(link) {
				console.log(link);
				return link.replace("&laquo; ", "").replace(" &raquo;", "");
			},
		},
	};
</script>