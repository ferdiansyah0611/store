import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
export default new Vuex.Store({
	state: {
		users : []
	},
	mutations: {
		ClientUser(state, data){
			this.state.users = data;
		}
	},
	actions: {}
});