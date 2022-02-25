export const routes = [
    {
        path: '/users',
        component: require('./components/users/index.vue').default
    },
    {
        path: '/profile/:id',
        component: require('./components/users/profile.vue').default
    }, {
        path: '/profile/:id/edit',
        component: require('./components/users/editprofile.vue').default
    },
    {
        path: '/payments/:user_id',
        component: require('./components/transactions/index.vue').default
    },
    {
        path: '/one_user_payments/:user_id',
        component: require('./components/transactions/one_user.vue').default
    },
    {
        path: '/logs/:user_id',
        component: require('./components/logs/index.vue').default
    }
];
