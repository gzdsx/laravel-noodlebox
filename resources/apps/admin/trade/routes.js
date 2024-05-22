import RefundList from "./RefundList";
import RefundDetail from "./RefundDetail";
import Transaction from "./Transaction";

module.exports = [
    {path: '/refund/list', component: RefundList, meta: {title: '退款管理', group: 'trade'}},
    {path: '/refund/detail/:id?', component: RefundDetail, meta: {title: '退款详情', group: 'trade'}},
    {path: '/transaction/list', component: Transaction, meta: {title: '交易流水', group: 'trade'}},
]
