//#if ${CarrinhoCompras} == "T"
//#if ${CarrinhoFinalizarCompras} == "T"
package br.com.webstore.features;

import br.com.webstore.facade.GenericFacade;
import br.com.webstore.model.Usuario;


import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.JRadioButton;

import javax.swing.*;

/**
 * @author webstore
 *
 */
public class PagamentoProduto  extends JFrame{

	/**
	 * 
	 */
	private static final long serialVersionUID = 2106593663257987796L;
	/**
	 * 
	 */
	JRadioButton cupom;
	JRadioButton cartaoCredito;
	JRadioButton boletoBancario;
	
	
	public PagamentoProduto(final GenericFacade gfacade, final Usuario usuario, final String valorTotal) {
		this.setLayout(null);	
		this.setTitle("Concluir Compra");
		this.setSize(400, 300);
		PagamentoProduto.this.setLocationRelativeTo(null);
		
		JLabel lblTituloValor = new JLabel("Valor Total");		
		lblTituloValor.setBounds(2,5,200,15);
		this.add(lblTituloValor);
		
		JLabel lblValor = new JLabel(valorTotal);
		lblValor.setBounds(2, 20, 200, 15);
		this.add(lblValor);
		
		
		JLabel lbFormaPagamento = new JLabel("Forma de Pagamento");
		lbFormaPagamento.setBounds(2, 80, 200, 15);

		this.add(lbFormaPagamento);

		//#if ${PgtoCartaoCredito} == "T"
		cartaoCredito = new JRadioButton("Cartao de Cr�dito", false);
		cartaoCredito.setBounds(20, 110, 200, 15);
		this.add(cartaoCredito);
		//#endif

		
		//#if ${PgtoBoletoBancario} == "T"
		boletoBancario = new JRadioButton("Boleto Banc�rio", false);
		boletoBancario.setBounds(20, 130, 200, 15); 
		this.add(boletoBancario);
		//#endif
		
		//#if ${PgtoCupomDesconto} == "T"
		cupom = new JRadioButton("Cupom", false);
		cupom.setBounds(20, 150, 200, 15);
		this.add(cupom);
		//#endif
		
		//#if ${EnvioPresente} == "T"
		JLabel lbEmbalarParaPresente = new JLabel("Embalar para Presente");
		lbEmbalarParaPresente.setBounds(2, 180, 150, 15);
		this.add(lbEmbalarParaPresente);
		
		JRadioButton rdBtEmbalarParaPresente = new JRadioButton("Sim", false);
		rdBtEmbalarParaPresente.setBounds(160, 180, 200, 15); 
		this.add(rdBtEmbalarParaPresente);
		//#endif
		
		JButton btFinalizarCompra = new JButton("Comprar");
		this.add(btFinalizarCompra);
		btFinalizarCompra .addActionListener(new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent arg0) {
				
				if (cartaoCredito.isSelected()) {
					//#if ${PgtoCartaoCredito} == "T"
					new PagamentoCartaoCredito(gfacade, usuario, "cartaoCredito");
					//#endif
				} else if (cupom.isSelected()) {
					//#if ${PgtoCupomDesconto} == "T"
					new PagamentoCupom(gfacade, usuario, "boleto",valorTotal);
					//#endif
				} else if (boletoBancario.isSelected()) {
					//#if ${PgtoBoletoBancario} == "T"
					new PagamentoBoleto(gfacade, usuario, "boleto",valorTotal);
					//#endif
				}else{
					JOptionPane.showMessageDialog(null, "Escolha uma forma de Pagamento!");
				}
				
				/*if (valorTotal!= null) {
					
				} else {
					
					FinalizarCompra pd = new FinalizarCompra(gfacade, usuario,"");
					
					final JDialog frame = new JDialog();
					
					frame.setModal(true);
					frame.setResizable(false);
					frame.setBounds(500, 400, 360, 200);
					frame.setVisible(true);
				}*/
				
			}
			
		});
		btFinalizarCompra.setBounds(110,210,160,23);		
		
		this.setVisible(true);
	}
		
	
}
//#endif
//#endif
