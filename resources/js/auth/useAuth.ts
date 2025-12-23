import { useState } from 'react';

export function useAuth() {
  // Простая заглушка для тестов и сборки — в реальном приложении заменить на реальную реализацию
  const [user] = useState<null | { id: number; role?: string }>(null);

  async function logout() {
    // заглушка
    return Promise.resolve();
  }

  return { user, logout };
}
