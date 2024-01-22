<?php 
return [
  'types' => [
    'shopping' => 'Achats',
    'charge' => 'Payer les frais',
    'withdraw' => 'retirer',
    'other' => 'autre',
  ],
  'pay' => [
    'states' => [
      0 => 'non payé',
      1 => 'Payé',
    ],
    'types' => [
      'balance' => 'paiement du solde',
      'wechatpay' => 'Paiement WeChat',
      'alipay' => 'Payer avec Ali-Pay',
    ],
  ],
  'transaction_subject_formater' => '%s et autres %d éléments',
  'close the transaction' => 'clôturer la transaction',
  'transaction details' => 'Détails de la transaction',
  'transaction success' => 'Transaction réussie',
  'transaction closed' => 'Négociation clôturée',
  'transaction records do not exist' => 'L\'enregistrement de la transaction n\'existe pas',
];