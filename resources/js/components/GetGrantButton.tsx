import React from 'react';

export interface GetGrantButtonProps {
  variant?: 'primary' | 'ghost';
  size?: 'sm' | 'md' | 'lg';
  onClick?: (e: React.MouseEvent) => void;
  children?: React.ReactNode;
}

export const GetGrantButton: React.FC<GetGrantButtonProps> = ({ variant = 'primary', size = 'md', onClick, children }) => {
  const base = 'inline-flex items-center justify-center rounded-md font-medium focus:outline-none';
  const sizes: Record<string, string> = {
    sm: 'px-3 py-1 text-sm',
    md: 'px-4 py-2 text-base',
    lg: 'px-6 py-3 text-lg',
  };
  const variants: Record<string, string> = {
    primary: 'bg-[#1055b2] text-white hover:opacity-95',
    ghost: 'bg-transparent text-[#1A1A1A] hover:bg-[#F5F5F5]',
  };

  return (
    <button className={`${base} ${sizes[size]} ${variants[variant]}`} onClick={onClick}>
      {children}
    </button>
  );
};
