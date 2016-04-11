//#if ${CarrinhoCheckout} == "T"
package br.com.webstore.features;

import java.awt.Color;
import java.awt.Desktop.Action;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import java.beans.PropertyChangeListener;
import java.math.BigDecimal;

import javax.swing.AbstractAction;
import javax.swing.JButton;
import javax.swing.JDialog;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JSeparator;
import javax.swing.JTextArea;
import javax.swing.SwingConstants;
import javax.swing.border.BevelBorder;
import javax.swing.table.DefaultTableModel;

import org.jdesktop.swingx.plaf.basic.CalendarRenderingHandler;

import br.com.webstore.dao.CarrinhoDao;
import br.com.webstore.dao.ProdutoDao;
import br.com.webstore.facade.GenericFacade;
import br.com.webstore.model.Carrinho;
import br.com.webstore.model.Produto;
import br.com.webstore.model.StatusVenda;
import br.com.webstore.model.Usuario;
import br.com.webstore.model.Venda;
import br.com.webstore.views.WebStoreEventMainScreenP;

import java.sql.*;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;
import java.util.List;
import java.util.Vector;

import javax.swing.JTable;
import javax.swing.ListSelectionModel;

public class CarrinhoCheckout extends JPanel {

	/**
	 * Serial version
	 */
	private static final long serialVersionUID = 8737213081913021625L;
	
	public static final String NAME = "Carrinho";

	/**
	 * Create the panel.
	 */
	Connection connection = null;
	private JTable table;
	private JLabel lblValor;
	private JScrollPane scrollPane;
	
	private Usuario user;
	private GenericFacade facade;
	
	private static CarrinhoCheckout instance;
	
	public static CarrinhoCheckout getInstance(final GenericFacade gfacade, final Usuario usuario){
		if(instance == null)
			instance = new CarrinhoCheckout(gfacade, usuario);
		
		return instance;
	}
	
	
	public CarrinhoCheckout(final GenericFacade gfacade, final Usuario usuario) {
		this.user = usuario;
		this.facade = gfacade;
		criarLayout(null);
	}
	
	
	public void criarLayout(final Produto produto){
		this.removeAll();
		setLayout(null);
		//List<Venda> venda = gfacade.findVendaByUser(usuario,  gfacade.findStatusVendabyName("Carrinho"));
		final Carrinho carrinho = Carrinho.getInstance();
		boolean flag = false;
		if(produto != null){
			for (Map.Entry<Produto, Integer> hashProduto : carrinho.getMapCarrinho().entrySet()) {
				if(hashProduto.getKey().getId() == produto.getId()){
				    carrinho.getMapCarrinho().put(hashProduto.getKey(), hashProduto.getValue() + 1);
				    flag = true;
				}
				
			}
			
			if(!flag){
				carrinho.putMapCarrinho(produto, 1);
			}	
			
		}
		//Cabe�alho
		final Vector<String> headers = new Vector<String>(3);
		headers.addElement(new String("Codigo"));
		headers.addElement(new String("Descri��o"));
		headers.addElement(new String("Quantidade"));
		headers.addElement(new String("Valor"));

		table = new JTable();
		JLabel lblTituloValor = new JLabel("Valor Total");
		lblValor = new JLabel("0");
		this.scrollPane = new JScrollPane();
		
		this.scrollPane.setBounds(0, 0, 480, 99);
		
		
		table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
		
		
		final DefaultTableModel modelCarrinho = new DefaultTableModel(headers, carrinho.getMapCarrinho().size());				
		CarrinhoCheckout.this.table.setModel(modelCarrinho);
		int row = 0;
		BigDecimal valorTotal = BigDecimal.ZERO;
		BigDecimal valorPorProduto = BigDecimal.ZERO;
		for (Map.Entry<Produto, Integer> hashProduto : carrinho.getMapCarrinho().entrySet()) {
			CarrinhoCheckout.this.table.getModel().setValueAt(hashProduto.getKey().getId().toString(), row, 0);
			CarrinhoCheckout.this.table.getModel().setValueAt(hashProduto.getKey().getDescricao(), row, 1);
			CarrinhoCheckout.this.table.getModel().setValueAt(hashProduto.getValue(), row, 2);		
			valorPorProduto = calculoDoValorQuantidade(hashProduto);
			CarrinhoCheckout.this.table.getModel().setValueAt(valorPorProduto, row, 3);
			
			valorTotal = valorTotal.add(valorPorProduto);
			row++;
		}		
		
		lblValor.setText(valorTotal.toString());
		//table.setModel(new CarrinhoDao(null).getCarrinho(venda.get(0)));
		javax.swing.Action action = new AbstractAction()
		{
		    public void actionPerformed(ActionEvent e)
		    {
		        TableCellListener tcl = (TableCellListener)e.getSource();
		        int id = Integer.parseInt(tcl.getTable().getValueAt(tcl.getRow(), 0).toString());
		        
		       for (Map.Entry<Produto, Integer> hashProduto : carrinho.getMapCarrinho().entrySet()) {
					if(hashProduto.getKey().getId() == id){
					    carrinho.getMapCarrinho().put(hashProduto.getKey(), Integer.parseInt(tcl.getNewValue().toString()));
					}
					
				}
       
/*		        System.out.println("Row   : " + tcl.getRow());
		        System.out.println("Column: " + tcl.getColumn());
		        System.out.println("Old   : " + tcl.getOldValue());
		        System.out.println("New   : " + tcl.getNewValue());*/
		    }
		};

		TableCellListener tcl = new TableCellListener(table, action);
		
		
		table.setBounds(22, 24, 361, 76);	
		table.setModel(modelCarrinho);
		
		add(table);
		
		JButton btnDetalhes = new JButton("Excluir");
		btnDetalhes .addActionListener(new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent arg0) {
				//ListSelectionModel lsm = CarrinhoCheckout.this.table.getSelectionModel();
				int index = CarrinhoCheckout.this.table.getSelectedRow();
				index = CarrinhoCheckout.this.table.convertRowIndexToModel(index);
				if (index == -1) {
					JOptionPane.showMessageDialog(null, "� necess�rio selecionar um item.");
				} else {
					//remover da tabela
					//CarrinhoCheckout.this.table.getRowCount();
					//CarrinhoCheckout.this.table.remove(index);
					Integer id = Integer.parseInt(CarrinhoCheckout.this.table.getValueAt(index, 0).toString());
					modelCarrinho.removeRow(index);
					CarrinhoCheckout.this.table.updateUI();
					
					//remover do HashMap 
					Set<Entry<Produto, Integer>> aux = carrinho.getMapCarrinho().entrySet();
					for (Map.Entry<Produto, Integer> hashProduto : aux) {
						if(hashProduto.getKey().getId() == id){
						    carrinho.getMapCarrinho().remove(hashProduto.getKey());
						}						
					}
					//tenho que atualizar a tabela
				}
				
			}
		});
		
		this.scrollPane.setViewportView(this.table);
		this.add(this.scrollPane);
		btnDetalhes .setBounds(440, 273, 90, 23);
		lblTituloValor.setBounds(270, 200, 100, 30);
		lblValor.setBounds(400, 200, 50, 30);
		this.add(btnDetalhes );
		this.add(lblTituloValor);
		this.add(lblValor);
	}


	/**
	 * @param hashProduto
	 * @return
	 */
	private BigDecimal calculoDoValorQuantidade(Entry<Produto, Integer> hashProduto) {
		BigDecimal valorProduto = hashProduto.getKey().getValor();
		BigDecimal quantidade = new BigDecimal(hashProduto.getValue());
		BigDecimal valorTotal = valorProduto.multiply(quantidade);
		return valorTotal;
	}
}
//#endif
