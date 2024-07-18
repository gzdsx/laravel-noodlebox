module.exports = [
    {
        path: '/lottery/settings',
        component: require('./Settings.vue').default,
        meta: {
            title: 'Lottery Settings',
            capabilities: ['administrator', 'manager']
        }
    },
    {
        path: '/lottery/prizes',
        component: require('./Prizes.vue').default,
        meta: {
            title: 'Prizes',
            capabilities: ['administrator', 'manager']
        }
    },
    {
        path: '/lottery/records',
        component: require('./Records.vue').default,
        meta: {
            title: 'Records',
            capabilities: ['administrator', 'manager']
        }
    },
]