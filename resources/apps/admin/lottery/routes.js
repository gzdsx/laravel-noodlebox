module.exports = [
    {
        path: '/lottery/settings',
        component: require('./Settings.vue').default,
        meta: {
            title: 'Lottery Settings',
        }
    },
    {
        path: '/lottery/prizes',
        component: require('./Prizes.vue').default,
        meta: {
            title: 'Prizes',
        }
    },
    {
        path: '/lottery/records',
        component: require('./Records.vue').default,
        meta: {
            title: 'Records',
        }
    },
]