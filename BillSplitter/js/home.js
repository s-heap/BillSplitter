$(document).ready( function() { 
	console.log('Javascript loaded my friend');
	
	$('#currentDebts').on('click', '.payDebtButton', function() {
		updateDebtStatus($(this).attr('debt_id'), 2);
		$(this).html('Payment Sent');
		$(this).parent().parent().fadeOut(1000);
	});
	
	$('#currentConfirmations').on('click', '.acceptPaymentButton', function() {
		updateDebtStatus($(this).attr('debt_id'), 3);
		$(this).parent().next().next().remove();
		$(this).html('Archiving Debt');
		$(this).parent().parent().parent().fadeOut(1000);
	});
	
	$('#currentConfirmations').on('click', '.declinePaymentButton', function() {
		updateDebtStatus($(this).attr('debt_id'), 1);
		$(this).parent().prev().remove();
		$(this).parent().prev().remove();
		$(this).html('Declining Debt');
		$(this).parent().parent().parent().fadeOut(1000);
	});
	
	$('#currentDebts').on('click', '.acceptDebtButton', function() {
		updateDebtStatus($(this).attr('debt_id'), 1);
		$(this).parent().parent().append('<div class="wordButtonBlock"><div class="payDebtButton" debt_id="' + $(this).attr('debt_id') + '"><div class="navButton"><a href="#">Pay Debt</a></div></div></div>');
		$(this).parent().prev().remove()
		$(this).parent().remove()
	});
	
	$('#currentDebts').on('click', '.declineDebtButton', function() {
		updateDebtStatus($(this).attr('debt_id'), 4);
		$(this).parent().next().remove();
		$(this).html('Debt Declined');
		$(this).parent().parent().fadeOut(1000);
		
	});
	
	$('#currentLoans').on('click', '.resendBillButton', function() {
		updateDebtStatus($(this).attr('debt_id'), 0);
		parent = $(this).parent().parent().html('Awaiting Payment');
	});
	
	$('#currentLoans').on('click', '.deleteBillButton', function() {
		updateDebtStatus($(this).attr('debt_id'), 5);
		$(this).parent().parent().parent().fadeOut(1000);
	});
});

function updateDebtStatus(debt_id, status) {
	$.ajax({
		url: "updateBill.php",
		contentType: "application/json; charset=utf-8",
		data: {
			'debt_id': debt_id,
			'status': status,
		},
	});
}