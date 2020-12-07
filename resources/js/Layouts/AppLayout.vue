<template>
	<div class="min-h-screen bg-gray-100">
		<nav class="bg-white border-b border-gray-100">
			<!-- Primary Navigation Menu -->
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between h-16">
					<div class="flex">
						<!-- Logo -->
						<div class="flex-shrink-0 flex items-center">
							<inertia-link :href="route('dashboard')">
								<jet-application-mark class="block h-9 w-auto" />
							</inertia-link>
						</div>

						<!-- Navigation Links -->
						<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
							<jet-nav-link
								:href="route('dashboard')"
								:active="route().current('dashboard')"
							>
								Dashboard
							</jet-nav-link>
						</div>
						<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
							<jet-nav-link
								:href="route('courses.index')"
								:active="route().current('courses.index')"
							>
								Courses
							</jet-nav-link>
						</div>
						<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
							<div class="mt-6" @click="showDropdown">
								<svg
									v-if="!notified"
									enable-background="new 0 0 24 24"
									height="15pt"
									viewBox="0 0 24 24"
									width="15pt"
									xmlns="http://www.w3.org/2000/svg"
								>
									<g>
										<path
											d="m21.379 16.913c-1.512-1.278-2.379-3.146-2.379-5.125v-2.788c0-3.519-2.614-6.432-6-6.92v-1.08c0-.553-.448-1-1-1s-1 .447-1 1v1.08c-3.387.488-6 3.401-6 6.92v2.788c0 1.979-.867 3.847-2.388 5.133-.389.333-.612.817-.612 1.329 0 .965.785 1.75 1.75 1.75h16.5c.965 0 1.75-.785 1.75-1.75 0-.512-.223-.996-.621-1.337z"
										/>
										<path
											d="m12 24c1.811 0 3.326-1.291 3.674-3h-7.348c.348 1.709 1.863 3 3.674 3z"
										/>
									</g>
								</svg>
								<svg
									v-else
									height="15pt"
									viewBox="-21 0 512 512"
									width="15pt"
									xmlns="http://www.w3.org/2000/svg"
								>
									<path
										d="m213.34375 512c38.636719 0 70.957031-27.542969 78.378906-64h-156.757812c7.425781 36.457031 39.746094 64 78.378906 64zm0 0"
									/>
									<path
										d="m362.933594 255.980469c-.085938 0-.171875.019531-.257813.019531-82.324219 0-149.332031-66.988281-149.332031-149.332031 0-22.636719 5.207031-44.035157 14.273438-63.277344-4.695313-.445313-9.453126-.722656-14.273438-.722656-82.472656 0-149.332031 66.855469-149.332031 149.332031v59.476562c0 42.21875-18.496094 82.070313-50.945313 109.503907-10.816406 9.238281-15.617187 23.957031-11.734375 38.316406 4.523438 16.703125 21.035157 27.371094 38.359375 27.371094h347.199219c18.175781 0 35.308594-11.777344 38.996094-29.589844 2.859375-13.78125-2.046875-27.542969-12.734375-36.523437-31.019532-26.003907-48.960938-64.214844-50.21875-104.574219zm0 0"
									/>
									<path
										d="m469.34375 106.667969c0 58.910156-47.753906 106.664062-106.667969 106.664062-58.910156 0-106.664062-47.753906-106.664062-106.664062 0-58.910157 47.753906-106.667969 106.664062-106.667969 58.914063 0 106.667969 47.757812 106.667969 106.667969zm0 0"
									/>
								</svg>
							</div>
							<div class="mt-6">
								<div
									class="bg-white flex flex-col rounded w-64 overflow-y-scroll h-20 z-50"
									v-bind:class="{
										hidden: isHidden && notifications.length > 0,
									}"
								>
									<a
										v-for="(notif, index) in notifications"
										v-bind:key="index"
										:href="route('courses.show', notif.message.course.id)"
										class="px-2 py-1 hover:bg-blue-400 rounded border shadow border-black mt-2"
										>{{ notif.message.message }}</a
									>
								</div>
							</div>
						</div>
					</div>

					<!-- Settings Dropdown -->
					<div class="hidden sm:flex sm:items-center sm:ml-6">
						<div class="ml-3 relative">
							<jet-dropdown align="right" width="48">
								<template #trigger>
									<button
										v-if="$page.jetstream.managesProfilePhotos"
										class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
									>
										<img
											class="h-8 w-8 rounded-full object-cover"
											:src="$page.user.profile_photo_url"
											:alt="$page.user.name"
										/>
									</button>

									<button
										v-else
										class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
									>
										<div>{{ $page.user.name }}</div>

										<div class="ml-1">
											<svg
												class="fill-current h-4 w-4"
												xmlns="http://www.w3.org/2000/svg"
												viewBox="0 0 20 20"
											>
												<path
													fill-rule="evenodd"
													d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
													clip-rule="evenodd"
												/>
											</svg>
										</div>
									</button>
								</template>

								<template #content>
									<!-- Account Management -->
									<div class="block px-4 py-2 text-xs text-gray-400">
										Manage Account
									</div>

									<jet-dropdown-link :href="route('profile.show')">
										Profile
									</jet-dropdown-link>

									<jet-dropdown-link
										:href="route('api-tokens.index')"
										v-if="$page.jetstream.hasApiFeatures"
									>
										API Tokens
									</jet-dropdown-link>

									<div class="border-t border-gray-100"></div>

									<!-- Team Management -->
									<template v-if="$page.jetstream.hasTeamFeatures">
										<div class="block px-4 py-2 text-xs text-gray-400">
											Manage Team
										</div>

										<!-- Team Settings -->
										<jet-dropdown-link
											:href="route('teams.show', $page.user.current_team)"
										>
											Team Settings
										</jet-dropdown-link>

										<jet-dropdown-link
											:href="route('teams.create')"
											v-if="$page.jetstream.canCreateTeams"
										>
											Create New Team
										</jet-dropdown-link>

										<div class="border-t border-gray-100"></div>

										<!-- Team Switcher -->
										<div class="block px-4 py-2 text-xs text-gray-400">
											Switch Teams
										</div>

										<template v-for="team in $page.user.all_teams">
											<form @submit.prevent="switchToTeam(team)" :key="team.id">
												<jet-dropdown-link as="button">
													<div class="flex items-center">
														<svg
															v-if="team.id == $page.user.current_team_id"
															class="mr-2 h-5 w-5 text-green-400"
															fill="none"
															stroke-linecap="round"
															stroke-linejoin="round"
															stroke-width="2"
															stroke="currentColor"
															viewBox="0 0 24 24"
														>
															<path
																d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
															></path>
														</svg>
														<div>{{ team.name }}</div>
													</div>
												</jet-dropdown-link>
											</form>
										</template>

										<div class="border-t border-gray-100"></div>
									</template>

									<!-- Authentication -->
									<form @submit.prevent="logout">
										<jet-dropdown-link as="button"> Logout </jet-dropdown-link>
									</form>
								</template>
							</jet-dropdown>
						</div>
					</div>

					<!-- Hamburger -->
					<div class="-mr-2 flex items-center sm:hidden">
						<button
							@click="showingNavigationDropdown = !showingNavigationDropdown"
							class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
						>
							<svg
								class="h-6 w-6"
								stroke="currentColor"
								fill="none"
								viewBox="0 0 24 24"
							>
								<path
									:class="{
										hidden: showingNavigationDropdown,
										'inline-flex': !showingNavigationDropdown,
									}"
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M4 6h16M4 12h16M4 18h16"
								/>
								<path
									:class="{
										hidden: !showingNavigationDropdown,
										'inline-flex': showingNavigationDropdown,
									}"
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M6 18L18 6M6 6l12 12"
								/>
							</svg>
						</button>
					</div>
				</div>
			</div>

			<!-- Responsive Navigation Menu -->
			<div
				:class="{
					block: showingNavigationDropdown,
					hidden: !showingNavigationDropdown,
				}"
				class="sm:hidden"
			>
				<div class="pt-2 pb-3 space-y-1">
					<jet-responsive-nav-link
						:href="route('dashboard')"
						:active="route().current('dashboard')"
					>
						Dashboard
					</jet-responsive-nav-link>
				</div>
				<div class="pt-2 pb-3 space-y-1">
					<jet-responsive-nav-link
						:href="route('courses.index')"
						:active="route().current('courses.index')"
					>
						Courses
					</jet-responsive-nav-link>
				</div>
				<div class="pt-2 pb-3 space-y-1">
					<jet-responsive-nav-link
						:href="route('courses.show', 1)"
						:active="route().current('courses.show', 1)"
					>
						Notification
					</jet-responsive-nav-link>
				</div>

				<!-- Responsive Settings Options -->
				<div class="pt-4 pb-1 border-t border-gray-200">
					<div class="flex items-center px-4">
						<div class="flex-shrink-0">
							<img
								class="h-10 w-10 rounded-full"
								:src="$page.user.profile_photo_url"
								:alt="$page.user.name"
							/>
						</div>

						<div class="ml-3">
							<div class="font-medium text-base text-gray-800">
								{{ $page.user.name }}
							</div>
							<div class="font-medium text-sm text-gray-500">
								{{ $page.user.email }}
							</div>
						</div>
					</div>
					<div class="mt-3 space-y-1">
						<jet-responsive-nav-link
							:href="route('profile.show')"
							:active="route().current('profile.show')"
						>
							Profile
						</jet-responsive-nav-link>

						<jet-responsive-nav-link
							:href="route('api-tokens.index')"
							:active="route().current('api-tokens.index')"
							v-if="$page.jetstream.hasApiFeatures"
						>
							API Tokens
						</jet-responsive-nav-link>

						<!-- Authentication -->
						<form method="POST" @submit.prevent="logout">
							<jet-responsive-nav-link as="button">
								Logout
							</jet-responsive-nav-link>
						</form>

						<!-- Team Management -->
						<template v-if="$page.jetstream.hasTeamFeatures">
							<div class="border-t border-gray-200"></div>

							<div class="block px-4 py-2 text-xs text-gray-400">
								Manage Team
							</div>

							<!-- Team Settings -->
							<jet-responsive-nav-link
								:href="route('teams.show', $page.user.current_team)"
								:active="route().current('teams.show')"
							>
								Team Settings
							</jet-responsive-nav-link>

							<jet-responsive-nav-link
								:href="route('teams.create')"
								:active="route().current('teams.create')"
							>
								Create New Team
							</jet-responsive-nav-link>

							<div class="border-t border-gray-200"></div>

							<!-- Team Switcher -->
							<div class="block px-4 py-2 text-xs text-gray-400">
								Switch Teams
							</div>

							<template v-for="team in $page.user.all_teams">
								<form @submit.prevent="switchToTeam(team)" :key="team.id">
									<jet-responsive-nav-link as="button">
										<div class="flex items-center">
											<svg
												v-if="team.id == $page.user.current_team_id"
												class="mr-2 h-5 w-5 text-green-400"
												fill="none"
												stroke-linecap="round"
												stroke-linejoin="round"
												stroke-width="2"
												stroke="currentColor"
												viewBox="0 0 24 24"
											>
												<path
													d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
												></path>
											</svg>
											<div>{{ team.name }}</div>
										</div>
									</jet-responsive-nav-link>
								</form>
							</template>
						</template>
					</div>
				</div>
			</div>
		</nav>

		<!-- Page Heading -->
		<header class="bg-white shadow">
			<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
				<slot name="header"></slot>
			</div>
		</header>

		<!-- Page Content -->
		<main>
			<slot></slot>
		</main>

		<!-- Modal Portal -->
		<portal-target name="modal" multiple> </portal-target>
	</div>
</template>
<script>
	import JetApplicationMark from "@/Jetstream/ApplicationMark";
	import JetDropdown from "@/Jetstream/Dropdown";
	import JetDropdownLink from "@/Jetstream/DropdownLink";
	import JetNavLink from "@/Jetstream/NavLink";
	import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";

	export default {
		components: {
			JetApplicationMark,
			JetDropdown,
			JetDropdownLink,
			JetNavLink,
			JetResponsiveNavLink,
		},

		data() {
			return {
				showingNavigationDropdown: false,
				isHidden: true,
				notifications: window.notifications,
				notified: window.notified,
			};
		},
		watch: {
			notifications: function (val) {
				if (this.isHidden) this.notified = true;
			},
		},
		mounted() {
			//console.log(notified, notifications);
		},
		methods: {
			showDropdown() {
				this.isHidden = !this.isHidden;
				this.notified = false;
			},

			switchToTeam(team) {
				this.$inertia.put(
					route("current-team.update"),
					{
						team_id: team.id,
					},
					{
						preserveState: false,
					}
				);
			},

			logout() {
				axios.post(route("logout").url()).then((response) => {
					window.location = "/";
				});
			},
		},
	};
</script>
