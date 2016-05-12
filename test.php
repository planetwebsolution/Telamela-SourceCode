<?php
 SELECT oi.fkOrderID,oi.Quantity, oi.ShippingPrice,o.ShippingCountry,oi.pkOrderItemID,oi.transaction_ID, oi.SubOrderID,
group_concat(oi.ItemName) as Items,concat(o.CustomerFirstName,' ',o.CustomerLastName) as 
CustomerName,o.OrderDateAdded,sum(oi.ItemTotalPrice) as ItemTotal,oi.Status,oi.DisputedStatus 
FROM tbl_order_items as oi LEFT JOIN tbl_order as o ON oi.fkOrderID = o.pkOrderID 
LEFT JOIN tbl_wholesaler as w on w.pkWholesalerID = oi.fkWholesalerID WHERE 1 AND fkShippingIDs = '4' 
AND oi.Status in('Pending','Posted','Completed','Canceled','Processing','Processed','Shipped','Delivered') 
AND oi.DisputedStatus in('Disputed,noDisputed','Resolved') Group BY oi.SubOrderID order by oi.pkOrderItemID DESC