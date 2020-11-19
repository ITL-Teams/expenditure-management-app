type AuthStatus = 'VALID_CREDENTIALS' | '2FA_REQUIRED' | 'NOT_AUTHORIZED'

export type CredentialsValidatorResponse = {
  status: AuthStatus
  user_data?: {
    user_id: string
    enterprise_account: boolean
  }
}
