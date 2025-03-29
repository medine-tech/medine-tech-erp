import { useState, useEffect, useCallback } from 'react';

interface Account {
  id: string;
  code: string;
  name: string;
  type: 'asset' | 'liability' | 'equity' | 'income' | 'expense';
  balance: number;
  isActive: boolean;
}

interface UseAccountsResult {
  accounts: Account[];
  isLoading: boolean;
  error: string | null;
  fetchAccounts: () => Promise<void>;
  getAccountById: (id: string) => Promise<Account | undefined>;
  createAccount: (data: Omit<Account, 'id'>) => Promise<Account>;
  updateAccount: (id: string, data: Partial<Omit<Account, 'id'>>) => Promise<Account>;
  deleteAccount: (id: string) => Promise<boolean>;
}

export function useAccounts(): UseAccountsResult {
  const [accounts, setAccounts] = useState<Account[]>([]);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const fetchAccounts = useCallback(async () => {
    setIsLoading(true);
    setError(null);
    
    try {
      // Aquí iría la llamada a la API real
      // Simulamos datos de respuesta
      const mockData: Account[] = [
        {
          id: '1',
          code: '1.1.01',
          name: 'Caja Principal',
          type: 'asset',
          balance: 15000.00,
          isActive: true,
        },
        {
          id: '2',
          code: '1.1.02',
          name: 'Banco Nacional Cuenta Corriente',
          type: 'asset',
          balance: 25680.45,
          isActive: true,
        },
        {
          id: '3',
          code: '2.1.01',
          name: 'Proveedores Nacionales',
          type: 'liability',
          balance: 8750.20,
          isActive: true,
        },
        {
          id: '4',
          code: '4.1.01',
          name: 'Ventas de Mercancía',
          type: 'income',
          balance: 32450.75,
          isActive: true,
        },
      ];
      
      // Simulamos un tiempo de carga
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      setAccounts(mockData);
      setIsLoading(false);
    } catch (err) {
      setError('Error al cargar las cuentas contables');
      setIsLoading(false);
    }
  }, []);

  useEffect(() => {
    fetchAccounts();
  }, [fetchAccounts]);

  const getAccountById = useCallback(async (id: string): Promise<Account | undefined> => {
    setIsLoading(true);
    
    try {
      // Aquí iría la llamada a la API real
      // Simulamos búsqueda en datos locales
      const account = accounts.find(acc => acc.id === id);
      
      // Simulamos un tiempo de carga
      await new Promise(resolve => setTimeout(resolve, 500));
      
      setIsLoading(false);
      return account;
    } catch (err) {
      setError('Error al obtener la cuenta contable');
      setIsLoading(false);
      return undefined;
    }
  }, [accounts]);

  const createAccount = useCallback(async (data: Omit<Account, 'id'>): Promise<Account> => {
    setIsLoading(true);
    
    try {
      // Aquí iría la llamada a la API real
      // Simulamos creación con ID generado
      const newAccount: Account = {
        ...data,
        id: `new-${Date.now()}`,
      };
      
      // Simulamos un tiempo de carga
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      setAccounts(prev => [...prev, newAccount]);
      setIsLoading(false);
      
      return newAccount;
    } catch (err) {
      setError('Error al crear la cuenta contable');
      setIsLoading(false);
      throw new Error('Error al crear la cuenta contable');
    }
  }, []);

  const updateAccount = useCallback(async (id: string, data: Partial<Omit<Account, 'id'>>): Promise<Account> => {
    setIsLoading(true);
    
    try {
      // Aquí iría la llamada a la API real
      // Simulamos actualización en datos locales
      const accountIndex = accounts.findIndex(acc => acc.id === id);
      
      if (accountIndex === -1) {
        throw new Error('Cuenta contable no encontrada');
      }
      
      const updatedAccount: Account = {
        ...accounts[accountIndex],
        ...data,
      };
      
      // Simulamos un tiempo de carga
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      const updatedAccounts = [...accounts];
      updatedAccounts[accountIndex] = updatedAccount;
      
      setAccounts(updatedAccounts);
      setIsLoading(false);
      
      return updatedAccount;
    } catch (err) {
      setError('Error al actualizar la cuenta contable');
      setIsLoading(false);
      throw new Error('Error al actualizar la cuenta contable');
    }
  }, [accounts]);

  const deleteAccount = useCallback(async (id: string): Promise<boolean> => {
    setIsLoading(true);
    
    try {
      // Aquí iría la llamada a la API real
      // Simulamos eliminación en datos locales
      const accountIndex = accounts.findIndex(acc => acc.id === id);
      
      if (accountIndex === -1) {
        throw new Error('Cuenta contable no encontrada');
      }
      
      // Simulamos un tiempo de carga
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      setAccounts(prev => prev.filter(acc => acc.id !== id));
      setIsLoading(false);
      
      return true;
    } catch (err) {
      setError('Error al eliminar la cuenta contable');
      setIsLoading(false);
      return false;
    }
  }, [accounts]);

  return {
    accounts,
    isLoading,
    error,
    fetchAccounts,
    getAccountById,
    createAccount,
    updateAccount,
    deleteAccount,
  };
}
