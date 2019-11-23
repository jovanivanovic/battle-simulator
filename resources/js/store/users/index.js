import { getLocalUser } from '../../services/auth';
import { logout } from '../../services/api/auth';

const current_user = getLocalUser();
const current_user_role = current_user ? current_user.user.role : null;

const state = {
    current_user,
    current_user_role,
    is_logged_in: !!current_user,
    auth_error: null,
};

const mutations = {
    check(state) {
        state.current_user = getLocalUser();
    },
    login(state) {
        state.auth_error = null;
    },
    loginSuccess(state, payload) {
        state.auth_error = null;
        state.is_logged_in = true;
        state.current_user = payload;
        state.current_user_role = payload.user.role;

        localStorage.setItem("user", JSON.stringify(state.current_user));
    },
    loginFail(state, payload) {
        state.auth_error = payload.error;
        state.user_details = null;
    },
    logout(state) {
        logout();
        localStorage.removeItem("user");

        state.is_logged_in = false;
        state.current_user = null;
        state.current_user_role = null;
    }
};

const actions = {
    login(context) {
        context.commit("login");
    },
    logout(context) {
        context.commit("logout");
    }
};

const getters = {
    currentUser(state) {
        return state.current_user;
    },
    currentUserRole(state) {
        return state.current_user_role;
    },
    isLoggedIn(state) {
        return state.is_logged_in;
    },
    isLoading(state) {
        return state.isLoading;
    },
    authError(state) {
        return state.authError;
    }
};

export default {
    state,
    getters,
    mutations,
    actions
};
