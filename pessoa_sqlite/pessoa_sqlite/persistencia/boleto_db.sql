-- Parte 3: tabela boleto
CREATE TABLE IF NOT EXISTS boleto (
    id              INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    data_vencimento DATE,
    data_emissao    DATE,
    data_pagamento  DATE,
    valor           FLOAT(10,2),
    desconto        FLOAT(10,2),
    juros           FLOAT(10,2),
    multa           FLOAT(10,2),
    mora            FLOAT(10,2),
    valor_pago      FLOAT(10,2)
);
